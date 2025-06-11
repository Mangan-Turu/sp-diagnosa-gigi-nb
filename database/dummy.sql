-- ========================
-- Dummy Data: m_gejala
-- ========================
INSERT INTO m_gejala (kode, nama, deskripsi, created_at, created_by)
VALUES
('G01', 'Gigi Berlubang', 'Lubang pada permukaan gigi akibat karies.', NOW(), 1),
('G02', 'Nyeri Saat Mengunyah', 'Rasa sakit saat menggigit makanan.', NOW(), 1),
('G03', 'Gusi Berdarah', 'Pendarahan pada gusi saat menyikat gigi.', NOW(), 1),
('G04', 'Bau Mulut', 'Bau tidak sedap dari mulut.', NOW(), 1),
('G05', 'Gigi Sensitif', 'Nyeri saat makan panas atau dingin.', NOW(), 1),
('G06', 'Gusi Bengkak', 'Pembengkakan pada gusi.', NOW(), 1),
('G07', 'Nanah di Gusi', 'Keluar cairan seperti nanah di sekitar gusi.', NOW(), 1),
('G08', 'Gigi Longgar', 'Gigi terasa goyang.', NOW(), 1),
('G09', 'Sakit Gigi Terus-menerus', 'Rasa nyeri yang konstan di gigi.', NOW(), 1),
('G10', 'Gigi Retak', 'Kerusakan atau patahan pada gigi.', NOW(), 1);

-- ==========================
-- Dummy Data: m_penyakit
-- ==========================
INSERT INTO m_penyakit (kode, nama, deskripsi, created_at, created_by)
VALUES
('P01', 'Karies Gigi', 'Kerusakan jaringan keras gigi akibat bakteri.', NOW(), 1),
('P02', 'Gingivitis', 'Radang pada gusi yang menyebabkan pendarahan.', NOW(), 1),
('P03', 'Periodontitis', 'Infeksi serius pada gusi yang merusak jaringan lunak dan tulang.', NOW(), 1),
('P04', 'Abses Gigi', 'Infeksi di ujung akar gigi atau di antara gusi dan gigi.', NOW(), 1);

-- ========================
-- Dummy Data: t_rules
-- ========================
INSERT INTO t_rules (penyakit_id, gejala_id, probabilitas, created_at, created_by)
VALUES
(1, 1, 0.9, NOW(), 1),
(1, 2, 0.7, NOW(), 1),
(1, 5, 0.6, NOW(), 1),
(2, 3, 0.85, NOW(), 1),
(2, 4, 0.6, NOW(), 1),
(2, 6, 0.5, NOW(), 1),
(3, 3, 0.6, NOW(), 1),
(3, 6, 0.8, NOW(), 1),
(3, 8, 0.7, NOW(), 1),
(4, 7, 0.85, NOW(), 1);

-- ===========================
-- Dummy Data: users
-- ===========================
INSERT INTO users (nama, alamat, role, username, email, password, created_at)
VALUES
('Admin Sistem', 'Jl. Pusat No. 1', 'admin', 'admin', 'admin@gigi.com', '$2y$10$uQ8F6F8sddLRHzI6CmQ7d.Ox7fEnTnC0/NXylGH0wZES9AzAp.xpC', NOW()), -- admin123
('Dewi Lestari', 'Jl. Melati No. 2', 'user', 'dewi', 'dewi@email.com', '$2y$10$WkX9V3Z0E/OLdKYQcbiFDuZ5s7M6iIQrQkTQ31KZPEF6Tw47YBqjS', NOW()), -- dewi123
('Budi Santoso', 'Jl. Mawar No. 5', 'user', 'budi', 'budi@email.com', '$2y$10$U5W.7YzA2FE3vB7CmT4cpeBDUT5avm3Uv6ZJBS9H.7j3ThjQoWhuC', NOW()), -- budi123
('Siti Aminah', 'Jl. Anggrek No. 7', 'user', 'siti', 'siti@email.com', '$2y$10$nHbZkWztGkYH6mnokDlmyumMeO8c9UR8j2PoX2/Vng1G8uzHQLIUe', NOW()); -- siti123

-- ===========================
-- Dummy Data: t_riwayat
-- ===========================
INSERT INTO t_riwayat (user_id, nama, alamat, jenis_kelamin, umur, penyakit_id, created_at, created_by)
VALUES
(2, 'Dewi Lestari', 'Jl. Melati No. 2', 'P', 27, 1, NOW(), 1),
(2, 'Dewi Lestari', 'Jl. Melati No. 2', 'P', 27, 2, NOW(), 1),
(3, 'Budi Santoso', 'Jl. Mawar No. 5', 'L', 35, 3, NOW(), 1),
(4, 'Siti Aminah', 'Jl. Anggrek No. 7', 'P', 22, 4, NOW(), 1),
(3, 'Budi Santoso', 'Jl. Mawar No. 5', 'L', 35, 1, NOW(), 1),
(4, 'Siti Aminah', 'Jl. Anggrek No. 7', 'P', 22, 2, NOW(), 1),
(2, 'Dewi Lestari', 'Jl. Melati No. 2', 'P', 27, 3, NOW(), 1),
(3, 'Budi Santoso', 'Jl. Mawar No. 5', 'L', 35, 4, NOW(), 1),
(4, 'Siti Aminah', 'Jl. Anggrek No. 7', 'P', 22, 1, NOW(), 1),
(2, 'Dewi Lestari', 'Jl. Melati No. 2', 'P', 27, 1, NOW(), 1);

INSERT INTO t_himpunan (id, variabel, batas_bawah, batas_atas) VALUES
(1, 'Mungkin', 0.00, 0.30),
(2, 'Sangat Mungkin', 0.30, 0.50),
(3, 'Pasti', 0.50, 0.80),
(4, 'Sangat Pasti', 0.80, 1.00);