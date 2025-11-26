// public/js/print.js - Versi dengan selector yang lebih spesifik
function printRoomInventory() {
    console.log('Print function called');
    
    // Cari tabel yang tepat - tabel pertama dengan header Room Inventory
    let inventoryTable = null;
    const tables = document.querySelectorAll('.room-table .table');
    
    tables.forEach(table => {
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        // Cari tabel yang memiliki header Room Inventory
        if (headers.includes('Room No.') && headers.includes('Type') && headers.includes('Features')) {
            inventoryTable = table;
        }
    });
    
    if (!inventoryTable) {
        alert('No room inventory data found!');
        return;
    }

    const printWindow = window.open('', '_blank');
    const rows = inventoryTable.querySelectorAll('tbody tr');
    const totalRooms = rows.length;
    
    // Ambil hanya kolom yang diinginkan
    let tableHTML = `
        <table border="1" style="width:100%; border-collapse:collapse; font-family:Arial;">
        <thead>
        <tr style="background-color:#f8f9fa;">
        <th style="padding:8px; border:1px solid #ddd;">Room No.</th>
        <th style="padding:8px; border:1px solid #ddd;">Type</th>
        <th style="padding:8px; border:1px solid #ddd;">Features</th>
        <th style="padding:8px; border:1px solid #ddd;">Rate</th>
        <th style="padding:8px; border:1px solid #ddd;">Status</th>
        </tr>
        </thead>
        <tbody>
    `;
    
    // Data rows - hanya dari tabel Room Inventory yang benar
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        
        tableHTML += '<tr>';
        
        // Room No. (kolom 1)
        if (cells[0]) tableHTML += `<td style="padding:8px; border:1px solid #ddd;">${cells[0].textContent.trim()}</td>`;
        
        // Type (kolom 2)  
        if (cells[1]) tableHTML += `<td style="padding:8px; border:1px solid #ddd;">${cells[1].textContent.trim()}</td>`;
        
        // Features (kolom 3)
        if (cells[2]) {
            const features = Array.from(cells[2].querySelectorAll('.room-feature'))
                .map(feature => feature.textContent.trim())
                .join(', ');
            tableHTML += `<td style="padding:8px; border:1px solid #ddd;">${features}</td>`;
        }
        
        // Rate (kolom 4)
        if (cells[3]) tableHTML += `<td style="padding:8px; border:1px solid #ddd;">${cells[3].textContent.trim()}</td>`;
        
        // Status (kolom 5)
        if (cells[4]) {
            const statusText = cells[4].textContent.trim();
            tableHTML += `<td style="padding:8px; border:1px solid #ddd;">${statusText}</td>`;
        }
        
        tableHTML += '</tr>';
    });
    
    tableHTML += '</tbody></table>';
    
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Room Inventory Report</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 20px;
                    color: #333;
                }
                h1 { 
                    color: #2c3e50; 
                    text-align: center; 
                    margin-bottom: 10px;
                }
                .info { 
                    display: flex; 
                    justify-content: space-between; 
                    margin-bottom: 20px;
                    padding: 10px;
                    background-color: #f8f9fa;
                    border-radius: 5px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th {
                    background-color: #4361ee;
                    color: white;
                    font-weight: bold;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                @media print {
                    body { margin: 0.5cm; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <h1>Room Inventory Report</h1>
            <div class="info">
                <div><strong>Generated Date:</strong> ${new Date().toLocaleDateString('id-ID')}</div>
                <div><strong>Total Rooms:</strong> ${totalRooms}</div>
            </div>
            ${tableHTML}
            <div style="margin-top: 20px; text-align: center; font-size: 12px; color: #666;">
                <p>Hotel Management System &copy; ${new Date().getFullYear()}</p>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                }
            </script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
}