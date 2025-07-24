<?php
require_once 'config.php';

// Function to get all data
function getAllData() {
    global $db;
    
    $data = [];
    
    // Get all main entries
    $stmt = $db->query("SELECT * FROM satpam_data ORDER BY created_at DESC");
    $mainData = $stmt->fetchAll();
    
    foreach ($mainData as $entry) {
        $id = $entry['id'];
        
        // Get kualifikasi data
        $stmt = $db->prepare("SELECT * FROM satpam_kualifikasi WHERE satpam_data_id = ?");
        $stmt->execute([$id]);
        $kualifikasi = $stmt->fetchAll();
        
        // Process each kualifikasi entry
        $kualifikasiData = [];
        $wilayah = [];
        $pelayanan = [];
        $companies = [];
        $totalGP = 0;
        $totalGM = 0;
        $totalGU = 0;
        $totalBD = 0;
        $dokumen = [];
        
        foreach ($kualifikasi as $k) {
            // Add to unique lists
            if (!in_array($k['wilayah'], $wilayah)) {
                $wilayah[] = $k['wilayah'];
            }
            
            if (!in_array($k['pelayanan'], $pelayanan)) {
                $pelayanan[] = $k['pelayanan'];
            }
            
            if (!empty($k['company_name']) && !in_array($k['company_name'], $companies)) {
                $companies[] = $k['company_name'];
            }
            
            // Add to totals
            $totalGP += $k['gada_pratama'];
            $totalGM += $k['gada_madya'];
            $totalGU += $k['gada_utama'];
            $totalBD += $k['belum_diklat'];
            
            // Get documents
            $stmt = $db->prepare("SELECT * FROM satpam_dokumen WHERE kualifikasi_id = ?");
            $stmt->execute([$k['id']]);
            $docs = $stmt->fetchAll();
            
            $kDokumen = null;
            if (count($docs) > 0) {
                $kDokumen = [
                    'name' => $docs[0]['filename'],
                    'size' => $docs[0]['filesize'],
                    'type' => $docs[0]['filetype'],
                    'path' => $docs[0]['filepath']
                ];
                $dokumen[] = $kDokumen;
            }
            
            // Add to kualifikasi data
            $kualifikasiData[] = [
                'wilayah' => $k['wilayah'],
                'pelayanan' => $k['pelayanan'],
                'companyName' => $k['company_name'],
                'companyAddress' => $k['company_address'],
                'gp' => $k['gada_pratama'],
                'gm' => $k['gada_madya'],
                'gu' => $k['gada_utama'],
                'bd' => $k['belum_diklat'],
                'dokumen' => $kDokumen
            ];
        }
        
        // Build complete data entry
        $data[] = [
            'id' => $id,
            'nama' => $entry['nama'],
            'wilayah' => $wilayah,
            'pelayanan' => $pelayanan,
            'companies' => $companies,
            'kualifikasi' => $kualifikasiData,
            'totalGP' => $totalGP,
            'totalGM' => $totalGM,
            'totalGU' => $totalGU,
            'totalBD' => $totalBD,
            'dokumen' => $dokumen,
            'created_at' => $entry['created_at']
        ];
    }
    
    return $data;
}

// Function to save data
function saveData($data) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Insert main data
        $stmt = $db->prepare("INSERT INTO satpam_data (nama) VALUES (?)");
        $stmt->execute([$data['nama']]);
        $mainId = $db->lastInsertId();
        
        // Insert kualifikasi data
        foreach ($data['kualifikasi'] as $k) {
            $stmt = $db->prepare("INSERT INTO satpam_kualifikasi 
                (satpam_data_id, wilayah, pelayanan, company_name, company_address, 
                gada_pratama, gada_madya, gada_utama, belum_diklat) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $mainId,
                $k['wilayah'],
                $k['pelayanan'],
                $k['companyName'] ?? null,
                $k['companyAddress'] ?? null,
                $k['gp'] ?? 0,
                $k['gm'] ?? 0,
                $k['gu'] ?? 0,
                $k['bd'] ?? 0
            ]);
            
            $kualifikasiId = $db->lastInsertId();
            
            // Save document info if exists
            if (isset($k['dokumen']) && $k['dokumen']) {
                $stmt = $db->prepare("INSERT INTO satpam_dokumen 
                    (kualifikasi_id, filename, filepath, filesize, filetype) 
                    VALUES (?, ?, ?, ?, ?)");
                
                $stmt->execute([
                    $kualifikasiId,
                    $k['dokumen']['name'],
                    $k['dokumen']['path'],
                    $k['dokumen']['size'],
                    $k['dokumen']['type']
                ]);
            }
        }
        
        $db->commit();
        
        // Return the saved data with ID
        $data['id'] = $mainId;
        return $data;
        
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
}

// Function to delete data
function deleteData($id) {
    global $db;
    
    try {
        // Get document paths to delete files
        $stmt = $db->prepare("
            SELECT d.filepath 
            FROM satpam_dokumen d
            JOIN satpam_kualifikasi k ON d.kualifikasi_id = k.id
            WHERE k.satpam_data_id = ?
        ");
        $stmt->execute([$id]);
        $documents = $stmt->fetchAll();
        
        // Delete files
        foreach ($documents as $doc) {
            if (file_exists($doc['filepath'])) {
                unlink($doc['filepath']);
            }
        }
        
        // Delete from database (cascade will handle related records)
        $stmt = $db->prepare("DELETE FROM satpam_data WHERE id = ?");
        return $stmt->execute([$id]);
        
    } catch (Exception $e) {
        throw $e;
    }
}

// Function to handle file upload
function uploadFile($file) {
    global $upload_dir;
    
    try {
        // Generate unique filename
        $filename = uniqid() . '-' . $file['name'];
        $filepath = $upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            return [
                'name' => $file['name'],
                'path' => $filepath,
                'size' => $file['size'],
                'type' => $file['type']
            ];
        } else {
            throw new Exception("Failed to move uploaded file");
        }
    } catch (Exception $e) {
        throw $e;
    }
}
?>