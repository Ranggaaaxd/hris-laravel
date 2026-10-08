# HRIS Laravel — Development Guidelines

## Project Rules

1. Project menggunakan Laravel sebagai backend framework.
2. Database menggunakan MySQL.
3. Frontend menggunakan Blade, Tailwind CSS, dan Alpine.js.
4. Ikuti Laravel best practices.
5. Gunakan PSR-12 dan coding convention yang konsisten.
6. Jangan membuat duplicate migration.
7. Jangan menghapus migration yang sudah digunakan tanpa alasan yang jelas.
8. Jangan mengubah fitur yang sudah berjalan tanpa memeriksa dependency dan dampaknya.
9. Gunakan Form Request untuk validasi input yang kompleks.
10. Gunakan Policy atau Gate untuk authorization.
11. Gunakan Service Layer jika business logic mulai kompleks.
12. Gunakan database transaction untuk proses yang membutuhkan atomicity.
13. Jangan menaruh business logic kompleks di Blade.
14. Jangan menaruh business logic kompleks langsung di controller.
15. Jangan hardcode credential.
16. Jangan commit `.env`.
17. Jangan mengekspos data sensitif karyawan.
18. Semua input user harus divalidasi.
19. Gunakan migration untuk perubahan struktur database.
20. Gunakan seeder/factory untuk data development dan testing.
21. Fitur penting harus memiliki automated test.
22. Jalankan test setelah perubahan signifikan.
23. Jangan menginstall package tambahan tanpa alasan yang jelas.
24. Sebelum mengubah arsitektur, periksa struktur project terlebih dahulu.
25. Jangan membuat file duplicate hanya karena nama file terlihat berbeda.
26. Gunakan naming convention yang konsisten.
27. Semua fitur baru harus mempertahankan backward compatibility dengan fitur sebelumnya jika memungkinkan.
28. Update README jika terdapat perubahan penting pada setup.
29. Setiap milestone harus dapat dijalankan.
30. Jangan melanjutkan ke fitur berikutnya apabila fondasi atau fitur sebelumnya masih mengalami error.

## Development Workflow

Setiap fitur HRIS harus mengikuti alur:

Requirement
→ Database Design
→ Migration
→ Model
→ Factory/Seeder
→ Request Validation
→ Policy/Authorization
→ Service jika diperlukan
→ Controller
→ Route
→ Blade UI
→ JavaScript/Alpine jika diperlukan
→ Automated Test
→ Manual Test
→ Documentation
→ Git Commit

## Important Rule

Jangan membuat seluruh aplikasi HRIS sekaligus.

Development harus dilakukan secara bertahap berdasarkan milestone.

Jangan membuat fitur yang belum diminta.

Sebelum mengimplementasikan fitur besar, jelaskan terlebih dahulu file yang akan dibuat/diubah dan alasan perubahan tersebut.
