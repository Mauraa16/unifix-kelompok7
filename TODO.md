# TODO: Dashboard Pelaporan

## Models
- [x] Create KategoriLaporan model
- [x] Create Laporan model with relationships
- [x] Create Komentar model with relationships

## Controllers
- [x] Create LaporanController with CRUD methods (index, create, store, show, edit, update, destroy)
- [x] Implement file upload handling for images
- [x] Add camera capture functionality in form

## Views
- [x] Create laporan.index view (dashboard for viewing reports)
- [x] Create laporan.create view (form for creating report with image upload/camera)
- [x] Create laporan.edit view (form for editing report before processed)
- [x] Create laporan.show view (view single report details)

## Routes
- [x] Update routes/web.php to include laporan resource routes with auth and role middleware

## Seeders
- [x] Update DatabaseSeeder to seed kategori_laporan data

## Storage
- [x] Configure storage for image uploads

## Testing
- [x] Test CRUD operations
- [x] Ensure role-based access (mahasiswa only)
- [x] Ensure edit/delete only for 'Belum Diproses' status
