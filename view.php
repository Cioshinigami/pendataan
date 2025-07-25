<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Penyebaran Satpam - Polda Jateng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <style>
        /* Keep all the existing styles */
        .checkbox-container {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #e2e8f0;
            padding: 10px;
            border-radius: 0.375rem;
        }
        .demo-notice {
            background-color: #fef3c7;
            color: #92400e;
            padding: 8px 16px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-weight: 500;
        }
        .header-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .logo-container {
            position: relative;
            overflow: hidden;
        }
        .logo-container::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: pulse 4s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(0.8); opacity: 0.5; }
        }
        .file-input-container {
            position: relative;
            overflow: hidden;
        }
        .file-input-container input[type=file] {
            position: absolute;
            font-size: 100px;
            right: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        .qualification-card {
            transition: all 0.3s ease;
        }
        .qualification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .loading-spinner {
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 4px solid #ffffff;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay hidden">
        <div class="bg-white p-5 rounded-lg shadow-lg flex flex-col items-center">
            <div class="loading-spinner mb-3"></div>
            <p id="loadingText" class="text-gray-700">Memproses data...</p>
        </div>
    </div>

    <!-- Elegant Header -->
    <header class="header-bg text-white py-6 mb-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="logo-container p-4">
                    <div class="flex items-center">
                        <!-- Police Badge SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mr-4" viewBox="0 0 100 100" fill="none">
                            <path d="M50 5L60 20H40L50 5Z" fill="gold"/>
                            <path d="M50 95C72.0914 95 90 77.0914 90 55C90 32.9086 72.0914 15 50 15C27.9086 15 10 32.9086 10 55C10 77.0914 27.9086 95 50 95Z" fill="#1e40af"/>
                            <path d="M50 85C66.5685 85 80 71.5685 80 55C80 38.4315 66.5685 25 50 25C33.4315 25 20 38.4315 20 55C20 71.5685 33.4315 85 50 85Z" fill="#1e3a8a"/>
                            <path d="M50 75C61.0457 75 70 66.0457 70 55C70 43.9543 61.0457 35 50 35C38.9543 35 30 43.9543 30 55C30 66.0457 38.9543 75 50 75Z" fill="#3b82f6"/>
                            <path d="M50 65C55.5228 65 60 60.5228 60 55C60 49.4772 55.5228 45 50 45C44.4772 45 40 49.4772 40 55C40 60.5228 44.4772 65 50 65Z" fill="white"/>
                            <path d="M50 60C52.7614 60 55 57.7614 55 55C55 52.2386 52.7614 50 50 50C47.2386 50 45 52.2386 45 55C45 57.7614 47.2386 60 50 60Z" fill="gold"/>
                        </svg>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold tracking-tight">PENDATAAN PENYEBARAN SATPAM</h1>
                            <h2 class="text-xl md:text-2xl font-semibold mt-1">DI WILAYAH POLDA JATENG</h2>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-center md:text-right">
                   
                    <div class="text-lg font-semibold">DITBINMAS POLDA JATENG</div>
                    <div class="text-xs mt-1 opacity-80">© 2025</div>
                </div>
            </div>
        </div>
    </header>
    
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 mb-8">
        <div class="demo-notice">
           
            <span class="font-bold"></span> 
        </div>
        
        <form id="dataForm" class="space-y-6">
            <!-- Nama -->
           
            
            <!-- Wilayah -->
            
          
            
        
            
            <div class="flex justify-center space-x-4">
                
                <button hidden="hidden" type="button" id="resetBtn" class="px-6 py-2 bg-gray-500 text-white font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200 overflow-hidden">
                   
                </button>
            </div>  <!-- Kualifikasi Input Container -->
            
        </form>
        
        <!-- Tabel Data -->
        <div class="mt-10">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-indigo-800">Data Tersimpan</h2>
                <button id="exportExcel" class="px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 flex items-center transition-all duration-200 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export Excel
                </button>
            </div>
            <div class="overflow-x-auto">
                <table id="dataTable" class="min-w-full bg-white border border-gray-300 shadow-sm rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-600 to-blue-500 text-white">
                            <th class="py-3 px-4 text-left">No</th>
                            <th class="py-3 px-4 text-left">Nama BUJP/INSTANSI/PERUSAHAAN</th>
                            <th class="py-3 px-4 text-left">Wilayah</th>
                            <th class="py-3 px-4 text-left">Pelayanan</th>
                            <th class="py-3 px-4 text-left">Perusahaan</th>
                            <th class="py-3 px-4 text-left">Gada Pratama</th>
                            <th class="py-3 px-4 text-left">Gada Madya</th>
                            <th class="py-3 px-4 text-left">Gada Utama</th>
                            <th class="py-3 px-4 text-left">Belum Diklat</th>
                            <th class="py-3 px-4 text-left">Dokumen</th>
                            <th class="py-3 px-4 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <!-- Data akan ditampilkan di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-4 text-center">
        <div class="max-w-6xl mx-auto px-4">
            <p>© 2025 DITBINMAS POLDA JATENG</p>
            <p class="text-sm text-gray-400 mt-1">Sistem Pendataan Penyebaran Satpam di Wilayah Polda Jateng</p>
        </div>
    </footer>

    <script>
        // API Configuration
        const API_URL = '/api'; // Change this to your API path
        
        // API functions
        const API = {
            async getData() {
                try {
                    showLoading('Mengambil data...');
                    const response = await fetch(`${API_URL}/index.php`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    hideLoading();
                    return data;
                } catch (error) {
                    hideLoading();
                    console.error('Error fetching data:', error);
                    showNotification('Gagal mengambil data dari server', 'error');
                    return [];
                }
            },
            
            async saveData(data) {
                try {
                    showLoading('Menyimpan data...');
                    const response = await fetch(`${API_URL}/index.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    const result = await response.json();
                    hideLoading();
                    return result;
                } catch (error) {
                    hideLoading();
                    console.error('Error saving data:', error);
                    showNotification('Gagal menyimpan data ke server', 'error');
                    return null;
                }
            },
            
            async deleteData(id) {
                try {
                    showLoading('Menghapus data...');
                    const response = await fetch(`${API_URL}/index.php/${id}`, {
                        method: 'DELETE'
                    });
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    const result = await response.json();
                    hideLoading();
                    return result.success;
                } catch (error) {
                    hideLoading();
                    console.error('Error deleting data:', error);
                    showNotification('Gagal menghapus data', 'error');
                    return false;
                }
            },
            
            async uploadFile(file) {
                try {
                    const formData = new FormData();
                    formData.append('file', file);
                    
                    const response = await fetch(`${API_URL}/upload.php`, {
                        method: 'POST',
                        body: formData
                    });
                    
                    if (!response.ok) throw new Error('Network response was not ok');
                    return await response.json();
                } catch (error) {
                    console.error('Error uploading file:', error);
                    showNotification('Gagal mengunggah file', 'error');
                    return null;
                }
            }
        };

        // Loading indicator functions
        function showLoading(message) {
            const overlay = document.getElementById('loadingOverlay');
            const text = document.getElementById('loadingText');
            text.textContent = message || 'Memproses...';
            overlay.classList.remove('hidden');
        }
        
        function hideLoading() {
            const overlay = document.getElementById('loadingOverlay');
            overlay.classList.add('hidden');
        }
        
        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-all duration-500 ease-in-out z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    ${type === 'success' 
                        ? `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                           </svg>`
                        : `<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                           </svg>`
                    }
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 500);
            }, 3000);
        }

        // Fungsi untuk menampilkan input kualifikasi berdasarkan wilayah dan pelayanan yang dipilih
        function updateKualifikasiInputs() {
            const wilayahChecked = document.querySelectorAll('.wilayah-checkbox:checked');
            const pelayananChecked = document.querySelectorAll('.pelayanan-checkbox:checked');
            const kualifikasiContainer = document.getElementById('kualifikasiContainer');
            const kualifikasiInputs = document.getElementById('kualifikasiInputs');
            
            kualifikasiInputs.innerHTML = '';
            
            if (wilayahChecked.length > 0 && pelayananChecked.length > 0) {
                kualifikasiContainer.classList.remove('hidden');
                
                wilayahChecked.forEach(wilayah => {
                    pelayananChecked.forEach(pelayanan => {
                        const wilayahValue = wilayah.value;
                        const pelayananValue = pelayanan.value;
                        const groupId = `${wilayahValue}-${pelayananValue}`.replace(/\s+/g, '-').replace(/\//g, '-');
                        
                        const groupDiv = document.createElement('div');
                        groupDiv.className = 'p-4 border border-gray-200 rounded-md bg-white shadow-sm qualification-card';
                        groupDiv.innerHTML = `
                            <div class="flex justify-between items-center mb-3">
                                <h4 class="font-medium text-indigo-800">${wilayahValue} - ${pelayananValue}</h4>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Data Kualifikasi</span>
                            </div>
                            
                            <!-- Company Information -->
                            <div class="mb-4 p-3 bg-gray-50 rounded-md">
                                <h5 class="font-medium text-gray-700 mb-2">Informasi Perusahaan</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                                        <input type="text" name="company-name-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan nama perusahaan">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Perusahaan</label>
                                        <textarea name="company-address-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" rows="2" placeholder="Masukkan alamat perusahaan"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Qualification Counts -->
                            <div class="mb-4">
                                <h5 class="font-medium text-gray-700 mb-2">Jumlah Kualifikasi</h5>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gada Pratama</label>
                                        <input type="number" min="0" name="gp-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gada Madya</label>
                                        <input type="number" min="0" name="gm-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gada Utama</label>
                                        <input type="number" min="0" name="gu-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="0">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Belum Diklat</label>
                                        <input type="number" min="0" name="bd-${groupId}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" value="0">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Document Upload -->
                            <div class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dokumen Pendukung</label>
                                <div class="file-input-container">
                                    <div class="flex">
                                        <input type="text" class="dokumen-name w-full px-3 py-2 border border-gray-300 rounded-l-md focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tidak ada file dipilih" readonly>
                                        <button type="button" class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-r-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                            Browse
                                        </button>
                                    </div>
                                    <input type="file" name="dokumen-${groupId}" class="dokumen-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX, JPG, JPEG, PNG (Max 5MB)</p>
                            </div>
                        `;
                        kualifikasiInputs.appendChild(groupDiv);
                    });
                });
                
                // Add event listeners for file inputs
                document.querySelectorAll('.dokumen-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const fileName = this.files[0] ? this.files[0].name : 'Tidak ada file dipilih';
                        const nameDisplay = this.parentElement.querySelector('.dokumen-name');
                        if (nameDisplay) {
                            nameDisplay.value = fileName;
                        }
                    });
                });
            } else {
                kualifikasiContainer.classList.add('hidden');
            }
        }

        // Event listener untuk checkbox wilayah dan pelayanan
        document.querySelectorAll('.wilayah-checkbox, .pelayanan-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateKualifikasiInputs);
        });

        // Fungsi untuk menampilkan data dalam tabel
        async function renderTable() {
            const tableBody = document.getElementById('tableBody');
            
            try {
                // Show loading indicator in table
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="11" class="py-6 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mb-2"></div>
                                <p class="text-gray-600">Memuat data...</p>
                            </div>
                        </td>
                    </tr>
                `;
                
                // Fetch data from API
                const data = await API.getData();
                
                tableBody.innerHTML = '';
                
                if (data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="11" class="py-6 text-center text-gray-500 bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p>Belum ada data tersimpan</p>
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                data.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.className = index % 2 === 0 ? 'bg-white hover:bg-blue-50' : 'bg-gray-50 hover:bg-blue-50';
                    
                    // Get company names as a comma-separated list
                    const companyNames = item.companies ? item.companies.join(', ') : '-';
                    
                    row.innerHTML = `
                        <td class="py-3 px-4 border-b">${index + 1}</td>
                        <td class="py-3 px-4 border-b font-medium">${item.nama}</td>
                        <td class="py-3 px-4 border-b">${item.wilayah}</td>
                        <td class="py-3 px-4 border-b">${item.companies}</td>
                        <td class="py-3 px-4 border-b text-center">${item.totalGP || 0}</td>
                        <td class="py-3 px-4 border-b text-center">${item.totalGM || 0}</td>
                        <td class="py-3 px-4 border-b text-center">${item.totalGU || 0}</td>
                        <td class="py-3 px-4 border-b text-center">${item.totalBD || 0}</td>
                        <td class="py-3 px-4 border-b">
                            ${item.dokumen && item.dokumen.length > 0 ? 
                                `<span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    ${item.dokumen.length} dokumen
                                </span>` : 
                                `<span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Tidak ada</span>`
                            }
                        </td>
                        <td class="py-3 px-4 border-b">
                            <button data-id="${item.id}" class="delete-btn text-red-600 hover:text-red-800 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                });
                
                // Event listener untuk tombol hapus
                document.querySelectorAll('.delete-btn').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        const id = parseInt(this.getAttribute('data-id'));
                        if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                            const success = await API.deleteData(id);
                            if (success) {
                                showNotification('Data berhasil dihapus', 'success');
                                renderTable();
                            }
                        }
                    });
                });
            } catch (error) {
                console.error('Error rendering table:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="11" class="py-6 text-center text-red-500">
                            <p>Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.</p>
                        </td>
                    </tr>
                `;
            }
        }

        // Form submission handler
        document.getElementById('dataForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const nama = document.getElementById('nama').value;
            
            const wilayahChecked = Array.from(document.querySelectorAll('.wilayah-checkbox:checked')).map(cb => cb.value);
            const pelayananChecked = Array.from(document.querySelectorAll('.pelayanan-checkbox:checked')).map(cb => cb.value);
            
            if (wilayahChecked.length === 0 || pelayananChecked.length === 0) {
                alert('Pilih minimal satu wilayah dan satu pelayanan');
                return;
            }
            
            // Kumpulkan data kualifikasi
            const kualifikasiData = [];
            let totalGP = 0, totalGM = 0, totalGU = 0, totalBD = 0;
            const dokumenFiles = [];
            const companies = [];
            
            // Process each qualification entry and upload documents
            for (const wilayah of wilayahChecked) {
                for (const pelayanan of pelayananChecked) {
                    const groupId = `${wilayah}-${pelayanan}`.replace(/\s+/g, '-').replace(/\//g, '-');
                    
                    // Get company information
                    const companyName = document.querySelector(`[name="company-name-${groupId}"]`).value;
                    const companyAddress = document.querySelector(`[name="company-address-${groupId}"]`).value;
                    
                    if (companyName && !companies.includes(companyName)) {
                        companies.push(companyName);
                    }
                    
                    const gpValue = parseInt(document.querySelector(`[name="gp-${groupId}"]`).value) || 0;
                    const gmValue = parseInt(document.querySelector(`[name="gm-${groupId}"]`).value) || 0;
                    const guValue = parseInt(document.querySelector(`[name="gu-${groupId}"]`).value) || 0;
                    const bdValue = parseInt(document.querySelector(`[name="bd-${groupId}"]`).value) || 0;
                    
                    totalGP += gpValue;
                    totalGM += gmValue;
                    totalGU += guValue;
                    totalBD += bdValue;
                    total = gpValue + gmValue + guValue;
                    // Get document file info and upload if exists
                    const dokumenInput = document.querySelector(`[name="dokumen-${groupId}"]`);
                    let dokumenInfo = null;
                    
                    if (dokumenInput && dokumenInput.files.length > 0) {
                        showLoading(`Mengunggah dokumen ${dokumenInput.files[0].name}...`);
                        dokumenInfo = await API.uploadFile(dokumenInput.files[0]);
                        hideLoading();
                        
                        if (dokumenInfo) {
                            dokumenFiles.push(dokumenInfo);
                        }
                    }
                    
                    kualifikasiData.push({
                        wilayah,
                        pelayanan,
                        companyName,
                        companyAddress,
                        gp: gpValue,
                        gm: gmValue,
                        gu: guValue,
                        bd: bdValue,
                        dokumen: dokumenInfo
                    });
                }
            }
            
            // Prepare data for saving
            const newItem = {
                nama,
                wilayah: wilayahChecked,
                pelayanan: pelayananChecked,
                kualifikasi: kualifikasiData,
                companies,
                totalGP,
                totalGM,
                totalGU,
                totalBD,
                total,
                dokumen: dokumenFiles
            };
            
            // Save data to server
            const savedItem = await API.saveData(newItem);
            
            if (savedItem) {
                showNotification('Data berhasil disimpan!', 'success');
                
                // Reset form
                this.reset();
                document.getElementById('kualifikasiContainer').classList.add('hidden');
                document.getElementById('kualifikasiInputs').innerHTML = '';
                
                // Refresh table
                renderTable();
            }
        });

        // Reset button handler
        document.getElementById('resetBtn').addEventListener('click', function() {
            document.getElementById('dataForm').reset();
            document.getElementById('kualifikasiContainer').classList.add('hidden');
            document.getElementById('kualifikasiInputs').innerHTML = '';
        });

        // Export to Excel handler
        document.getElementById('exportExcel').addEventListener('click', async function() {
            try {
                showLoading('Menyiapkan data untuk ekspor...');
                
                const data = await API.getData();
                
                if (data.length === 0) {
                    hideLoading();
                    alert('Tidak ada data untuk diekspor');
                    return;
                }
                
                // Prepare data for Excel - main sheet
                const mainSheetData = [
                    ['No', 'Nama Petugas', 'Wilayah', 'Pelayanan', 'Perusahaan', 'Gada Pratama', 'Gada Madya', 'Gada Utama', 'Belum Diklat', 'Dokumen']
                ];
                
                data.forEach((item, index) => {
                    const companyNames = item.companies ? item.companies.join(', ') : '-';
                    
                    mainSheetData.push([
                        index + 1,
                        item.nama,
                        item.wilayah,
                        item.pelayanan,
                        companyNames,
                        item.totalGP || 0,
                        item.totalGM || 0,
                        item.totalGU || 0,
                        item.totalBD || 0,
                        item.dokumen && item.dokumen.length > 0 ? item.dokumen.map(d => d.name).join(', ') : '-'
                    ]);
                });
                
                // Prepare detailed data for second sheet
                const detailSheetData = [
                    ['No', 'Nama Petugas', 'Wilayah', 'Pelayanan', 'Nama Perusahaan', 'Alamat Perusahaan', 'Gada Pratama', 'Gada Madya', 'Gada Utama', 'Belum Diklat', 'Dokumen']
                ];
                
                let detailIndex = 1;
                data.forEach(item => {
                    item.kualifikasi.forEach(k => {
                        detailSheetData.push([
                            detailIndex++,
                            item.nama,
                            k.wilayah,
                            k.pelayanan,
                            k.companyName || '-',
                            k.companyAddress || '-',
                            k.gp || 0,
                            k.gm || 0,
                            k.gu || 0,
                            k.bd || 0,
                            k.dokumen ? k.dokumen.name : '-'
                        ]);
                    });
                });
                
                // Create workbook with multiple sheets
                const wb = XLSX.utils.book_new();
                
                // Add main summary sheet
                const ws1 = XLSX.utils.aoa_to_sheet(mainSheetData);
                XLSX.utils.book_append_sheet(wb, ws1, 'Ringkasan Data');
                
                // Add detailed data sheet
                const ws2 = XLSX.utils.aoa_to_sheet(detailSheetData);
                XLSX.utils.book_append_sheet(wb, ws2, 'Data Detail');
                
                hideLoading();
                
                // Generate Excel file and trigger download
                XLSX.writeFile(wb, 'Data_Penyebaran_Satpam_Polda_Jateng.xlsx');
                
            } catch (error) {
                hideLoading();
                console.error('Error exporting to Excel:', error);
                showNotification('Gagal mengekspor data ke Excel', 'error');
            }
        });

        // Initialize table on page load
        document.addEventListener('DOMContentLoaded', function() {
            renderTable();
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9643421da6e35f31',t:'MTc1MzM1ODQzOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
