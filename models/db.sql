-- Active: 1734576880718@@127.0.0.1@3306@si_penjualan_bahan_bangunan
/* =======================================================
BAGIAN 1: TEMPLATE (JANGAN DIUBAH / DO NOT CHANGE)
Sesuai script asli pengguna (English)
======================================================= */
CREATE TABLE
  utilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logo VARCHAR(50),
    name_web VARCHAR(75),
    keyword TEXT,
    description TEXT,
    author VARCHAR(50)
  );

CREATE TABLE
  auth (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(50),
    bg VARCHAR(35),
    model INT DEFAULT 2
  );

CREATE TABLE
  user_role (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(35)
  );

INSERT INTO
  user_role (role)
VALUES
  ('Administrator'),
  ('Owner'),
  ('Member');

CREATE TABLE
  user_status (
    id_status INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(35)
  );

INSERT INTO
  user_status (status)
VALUES
  ('Active'),
  ('No Active');

CREATE TABLE
  users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT,
    id_active INT,
    en_user VARCHAR(75),
    token CHAR(6),
    name VARCHAR(100),
    image VARCHAR(100),
    email VARCHAR(75),
    password VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_role) REFERENCES user_role (id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
    FOREIGN KEY (id_active) REFERENCES user_status (id_status) ON UPDATE NO ACTION ON DELETE NO ACTION
  );

CREATE TABLE
  user_menu (
    id_menu INT AUTO_INCREMENT PRIMARY KEY,
    icon VARCHAR(50),
    menu VARCHAR(50)
  );

CREATE TABLE
  user_sub_menu (
    id_sub_menu INT AUTO_INCREMENT PRIMARY KEY,
    id_menu INT,
    id_active INT,
    title VARCHAR(50),
    url VARCHAR(50),
    FOREIGN KEY (id_menu) REFERENCES user_menu (id_menu) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (id_active) REFERENCES user_status (id_status) ON UPDATE NO ACTION ON DELETE NO ACTION
  );

CREATE TABLE
  user_access_menu (
    id_access_menu INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT,
    id_menu INT,
    FOREIGN KEY (id_role) REFERENCES user_role (id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
    FOREIGN KEY (id_menu) REFERENCES user_menu (id_menu) ON UPDATE CASCADE ON DELETE CASCADE
  );

CREATE TABLE
  user_access_sub_menu (
    id_access_sub_menu INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT,
    id_sub_menu INT,
    FOREIGN KEY (id_role) REFERENCES user_role (id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
    FOREIGN KEY (id_sub_menu) REFERENCES user_sub_menu (id_sub_menu) ON UPDATE CASCADE ON DELETE CASCADE
  );


/* =======================================================
BAGIAN 2: SKEMA SISTEM PENJUALAN TOKO SUMBER LOGAM
Terintegrasi dengan tabel users dari template di atas
======================================================= */

-- Menambahkan role Kasir & Pelanggan ke dalam user_role bawaan template
INSERT INTO 
  user_role (role) 
VALUES 
  ('Kasir'), 
  ('Pelanggan');

-- 1. tabel_pelanggan (Sebagai profil tambahan pengguna)
-- Karena tabel users dari template tidak memiliki field alamat & nomor telepon
CREATE TABLE 
  tabel_pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL, -- Terhubung ke akun login di tabel users
    alamat TEXT NOT NULL,
    nomor_telepon VARCHAR(20) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- 2. tabel_katalog
CREATE TABLE 
  tabel_katalog (
    kode_katalog VARCHAR(50) PRIMARY KEY, 
    nama_barang VARCHAR(150) NOT NULL,
    deskripsi_barang TEXT,
    harga_barang DECIMAL(15, 2) NOT NULL,
    satuan VARCHAR(50) NOT NULL,
    gambar_barang VARCHAR(100) 
  );

-- 3. tabel_inventori
CREATE TABLE 
  tabel_inventori (
    id_inventori INT AUTO_INCREMENT PRIMARY KEY,
    kode_katalog VARCHAR(50) NOT NULL UNIQUE, 
    stok_tersedia INT NOT NULL DEFAULT 0,
    terakhir_diupdate DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    FOREIGN KEY (kode_katalog) REFERENCES tabel_katalog(kode_katalog) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- 4. tabel_pesanan
CREATE TABLE 
  tabel_pesanan (
    id_pesanan INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL, -- Terhubung langsung ke pembeli di tabel users
    tanggal_pesan DATETIME DEFAULT CURRENT_TIMESTAMP, 
    status_pesanan ENUM('Menunggu Konfirmasi', 'Diproses', 'Selesai', 'Batal') DEFAULT 'Menunggu Konfirmasi', 
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- 5. tabel_transaksi
CREATE TABLE 
  tabel_transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_pesanan INT NOT NULL,
    kode_katalog VARCHAR(50) NOT NULL,
    jumlah_barang INT NOT NULL,
    tanggal_transaksi DATE NOT NULL,
    total_harga DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (id_pesanan) REFERENCES tabel_pesanan(id_pesanan) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (kode_katalog) REFERENCES tabel_katalog(kode_katalog) ON DELETE CASCADE ON UPDATE CASCADE
  );

-- 6. tabel_laporan_penjualan
CREATE TABLE 
  tabel_laporan_penjualan (
    id_laporan INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_cetak DATETIME DEFAULT CURRENT_TIMESTAMP, 
    periode_awal DATE NOT NULL,                       
    periode_akhir DATE NOT NULL,                      
    total_transaksi_berhasil INT NOT NULL DEFAULT 0,  
    total_pendapatan DECIMAL(15, 2) NOT NULL,         
    dicetak_oleh INT NOT NULL, -- Terhubung ke Admin/Kasir di tabel users
    FOREIGN KEY (dicetak_oleh) REFERENCES users(id_user) ON DELETE CASCADE ON UPDATE CASCADE
  );