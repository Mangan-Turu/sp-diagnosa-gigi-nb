-- Buat database
CREATE DATABASE IF NOT EXISTS spk_gigi;
USE spk_gigi;

-- Tabel: m_gejala
CREATE TABLE m_gejala (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at DATETIME,
    created_by INT,
    update_at DATETIME,
    update_by INT,
    deleted BOOLEAN DEFAULT 0,
    deleted_at DATETIME,
    deleted_by INT
);

-- Tabel: m_penyakit
CREATE TABLE m_penyakit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(10) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at DATETIME,
    created_by INT,
    update_at DATETIME,
    update_by INT,
    deleted BOOLEAN DEFAULT 0,
    deleted_at DATETIME,
    deleted_by INT
);

-- Tabel: rules
CREATE TABLE t_rules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    penyakit_id INT NOT NULL,
    gejala_id INT NOT NULL,
    probabilitas DECIMAL(5,4) NOT NULL,
    created_at DATETIME,
    created_by INT,
    update_at DATETIME,
    update_by INT,
    deleted BOOLEAN DEFAULT 0,
    deleted_at DATETIME,
    deleted_by INT,
    FOREIGN KEY (penyakit_id) REFERENCES m_penyakit(id),
    FOREIGN KEY (gejala_id) REFERENCES m_gejala(id),
    UNIQUE (penyakit_id, gejala_id)
);

-- Tabel: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    alamat TEXT,
    role ENUM('admin','pasien') NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255) NOT NULL,
    created_at DATETIME,
    created_by INT,
    update_at DATETIME,
    update_by INT,
    deleted BOOLEAN DEFAULT 0,
    deleted_at DATETIME,
    deleted_by INT
);

-- Tabel: t_riwayat
CREATE TABLE t_riwayat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT, 
    nama VARCHAR(100),
    alamat TEXT,
    jenis_kelamin ENUM('L','P'),
    umur INT,
    gejala_ids TEXT, 
    penyakit_id INT,
    created_at DATETIME,
    created_by INT,
    update_at DATETIME,
    update_by INT,
    deleted BOOLEAN DEFAULT 0,
    deleted_at DATETIME,
    deleted_by INT,
    FOREIGN KEY (penyakit_id) REFERENCES m_penyakit(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE t_himpunan (
    id INT PRIMARY KEY,
    variabel VARCHAR(50),
    batas_bawah DECIMAL(3,2),
    batas_atas DECIMAL(3,2),
    created_at DATETIME,
    update_at DATETIME
);
