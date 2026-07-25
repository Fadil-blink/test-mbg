-- ===================================================================
-- DATABASE MBGFIX - E-Procurement System for Agricultural Commodities
-- ===================================================================
-- Sistem E-Procurement Multi-Stakeholder untuk Komoditas Pertanian
-- dengan 3 modul utama: PUSAT, SPPG (Pembeli), dan SUPPLIER
-- ===================================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS `mbgfix` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `mbgfix`;

-- ===================================================================
-- 1. TABEL ROLES (Peran Pengguna)
-- ===================================================================
CREATE TABLE `roles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert roles
INSERT INTO `roles` (`name`, `description`) VALUES
('admin_pusat', 'Administrator Pusat - Penuh akses ke semua modul'),
('auditor_pusat', 'Auditor Pusat - Monitoring nasional dan audit'),
('auditor_khusus', 'Auditor Khusus - Audit insidental'),
('manager_sppg', 'Manager SPPG - Kelola pesanan dan anggaran'),
('staf_sppg', 'Staf SPPG - Petugas operasional SPPG'),
('supplier', 'Supplier - Penjual komoditas'),
('admin_supplier', 'Admin Supplier - Kelola produk dan pesanan'),
('system', 'System - Akun sistem untuk automation');

-- ===================================================================
-- 2. TABEL USERS (Pengguna Sistem)
-- ===================================================================
CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(20),
  `role_id` INT NOT NULL,
  `organization_id` INT,
  `is_active` BOOLEAN DEFAULT TRUE,
  `last_login` DATETIME,
  `last_ip` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`id`) ON DELETE RESTRICT,
  KEY `idx_email` (`email`),
  KEY `idx_username` (`username`),
  KEY `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample users
INSERT INTO `users` (`username`, `email`, `password_hash`, `full_name`, `phone`, `role_id`, `is_active`, `last_login`) VALUES
('admin_pusat', 'admin@pusat.go.id', MD5('password123'), 'Administrator Pusat', '081-2345-6789', 1, TRUE, NOW()),
('auditor_utama', 'budi.s@audit.go.id', MD5('password123'), 'Budi Santoso', '082-3456-7890', 2, TRUE, NOW()),
('sppg_surabaya', 'manager@sppg-surabaya.go.id', MD5('password123'), 'Drs. Ahmad Fauzi', '083-4567-8901', 3, TRUE, NOW()),
('supplier_maju', 'admin@tanimaju.com', MD5('password123'), 'CV. Tani Sejahtera', '085-5678-9012', 7, TRUE, NOW()),
('system_bot', 'system@mbgfix.local', MD5('system123'), 'System Automation', NULL, 8, TRUE, NULL);

-- ===================================================================
-- 3. TABEL SPPG (Satuan Perangkat Kerja Pemerintah - Pembeli)
-- ===================================================================
CREATE TABLE `sppg` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(200) NOT NULL,
  `type` ENUM('unit_gizi', 'rumah_sakit', 'panti_asuhan', 'lembaga_sosial', 'lainnya') DEFAULT 'lainnya',
  `province` VARCHAR(100),
  `city` VARCHAR(100),
  `district` VARCHAR(100),
  `address` TEXT,
  `phone` VARCHAR(20),
  `email` VARCHAR(100),
  `pic_name` VARCHAR(150),
  `pic_phone` VARCHAR(20),
  `budget_annual` BIGINT COMMENT 'Anggaran tahunan',
  `is_verified` BOOLEAN DEFAULT FALSE,
  `status` ENUM('aktif', 'inactive', 'suspended') DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_code` (`code`),
  KEY `idx_province` (`province`),
  KEY `idx_city` (`city`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample SPPG
INSERT INTO `sppg` (`code`, `name`, `type`, `province`, `city`, `district`, `address`, `phone`, `email`, `pic_name`, `pic_phone`, `budget_annual`, `is_verified`, `status`) VALUES
('SPPG-JTM-001', 'SPPG Surabaya Barat', 'unit_gizi', 'Jawa Timur', 'Surabaya', 'Surabaya Barat', 'Jl. Raya Wonokromo No. 123', '031-1234567', 'sppg.surabaya@email.com', 'Dr. Ahmad Fauzi', '081-2345678', 500000000, TRUE, 'aktif'),
('SPPG-JTM-002', 'SPPG Surabaya Timur', 'rumah_sakit', 'Jawa Timur', 'Surabaya', 'Surabaya Timur', 'Jl. Raya Wonokromo No. 456', '031-2345678', 'sppg.surabaya.timur@email.com', 'Dr. Siti Nurhasanah', '082-3456789', 750000000, TRUE, 'aktif'),
('SPPG-JTM-003', 'SPPG Sidoarjo', 'panti_asuhan', 'Jawa Timur', 'Sidoarjo', 'Sidoarjo', 'Jl. Gatot Subroto No. 789', '031-3456789', 'sppg.sidoarjo@email.com', 'Ir. Bambang Suryanto', '083-4567890', 400000000, TRUE, 'aktif'),
('SPPG-JKT-001', 'SPPG Jakarta Pusat', 'unit_gizi', 'DKI Jakarta', 'Jakarta Pusat', 'Jakarta Pusat', 'Jl. Medan Merdeka No. 101', '021-5555555', 'sppg.jakarta@email.com', 'Ir. Hartono', '088-5555555', 800000000, TRUE, 'aktif');

-- ===================================================================
-- 4. TABEL SUPPLIERS (Penjual/Supplier)
-- ===================================================================
CREATE TABLE `suppliers` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(200) NOT NULL,
  `type` ENUM('umkm', 'cv', 'pt', 'koperasi', 'petani', 'distributor', 'lainnya') DEFAULT 'umkm',
  `tax_id` VARCHAR(50),
  `province` VARCHAR(100),
  `city` VARCHAR(100),
  `address` TEXT,
  `phone` VARCHAR(20),
  `email` VARCHAR(100),
  `pic_name` VARCHAR(150),
  `pic_phone` VARCHAR(20),
  `rating` DECIMAL(3,2) DEFAULT 0.00 COMMENT 'Rating 0-5',
  `total_sales` BIGINT DEFAULT 0 COMMENT 'Total penjualan dalam Rupiah',
  `total_transactions` INT DEFAULT 0 COMMENT 'Jumlah transaksi selesai',
  `is_verified` BOOLEAN DEFAULT FALSE,
  `verification_date` DATETIME,
  `status` ENUM('aktif', 'pending', 'suspend', 'inactive') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `idx_code` (`code`),
  KEY `idx_name` (`name`),
  KEY `idx_city` (`city`),
  KEY `idx_status` (`status`),
  KEY `idx_is_verified` (`is_verified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample suppliers
INSERT INTO `suppliers` (`code`, `name`, `type`, `tax_id`, `province`, `city`, `address`, `phone`, `email`, `pic_name`, `pic_phone`, `rating`, `total_sales`, `total_transactions`, `is_verified`, `verification_date`, `status`) VALUES
('SUP-001', 'CV. Sembako Jaya', 'cv', '12.345.678.9-012', 'Jawa Timur', 'Surabaya', 'Jl. Kali Rungkut No. 45', '031-6666666', 'info@sembakowkaya.com', 'Hendra Wijaya', '085-6666666', 4.8, 145820000, 156, TRUE, '2024-01-15', 'aktif'),
('SUP-002', 'PT Telur Nasional', 'pt', '98.765.432.1-210', 'Jawa Barat', 'Bandung', 'Jl. Raya Bandung Raya No. 100', '022-7777777', 'telur@ptelurnasional.com', 'Suparno', '086-7777777', 4.5, 98500000, 89, TRUE, '2024-02-20', 'aktif'),
('SUP-003', 'UD Sayur Mayur', 'umkm', NULL, 'Jawa Timur', 'Surabaya', 'Pasar Pon No. 12', '031-8888888', 'sayur.mayur@gmail.com', 'Ibu Siti', '087-8888888', 4.2, 42300000, 45, TRUE, '2024-01-30', 'aktif'),
('SUP-004', 'Farm Fresh Milk', 'distributor', '55.555.555.5-555', 'Jawa Timur', 'Gresik', 'Jl. Industri No. 78', '031-9999999', 'info@farmfreshmilk.com', 'Bambang Setiawan', '089-9999999', 4.6, 156700000, 112, TRUE, '2024-02-01', 'aktif'),
('SUP-005', 'Koperasi Berkah Tani', 'koperasi', '11.111.111.1-111', 'Jawa Timur', 'Mojokerto', 'Jl. Pendidikan No. 34', '0321-10101010', 'koperasi.berkah@coop.id', 'Drs. Soerjono', '089-1010101', 3.9, 34500000, 38, TRUE, '2024-03-10', 'aktif');

-- ===================================================================
-- 5. TABEL CATEGORIES (Kategori Produk)
-- ===================================================================
CREATE TABLE `categories` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT,
  `icon` VARCHAR(100),
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `idx_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample categories
INSERT INTO `categories` (`code`, `name`, `description`, `icon`, `is_active`) VALUES
('CAT-001', 'Serealia', 'Beras, Jagung, Gandum, dan produk sejenis', 'grain', TRUE),
('CAT-002', 'Lauk Pauk', 'Telur, Daging, Ikan, Kedelai', 'egg', TRUE),
('CAT-003', 'Sayuran', 'Sayuran segar: Bayam, Kangkung, Brokoli, dll', 'leaf', TRUE),
('CAT-004', 'Buah-buahan', 'Buah segar dan olahan', 'apple', TRUE),
('CAT-005', 'Susu & Produk Olahan', 'Susu, Yogurt, Keju', 'milk', TRUE),
('CAT-006', 'Minyak & Mentega', 'Minyak goreng, minyak kelapa', 'oil', TRUE),
('CAT-007', 'Bumbu & Rempah', 'Bumbu, Rempah, Garam', 'spice', TRUE),
('CAT-008', 'Makanan Siap Saji', 'Makanan yang siap dimakan', 'food', TRUE);

-- ===================================================================
-- 6. TABEL PRODUCTS (Produk)
-- ===================================================================
CREATE TABLE `products` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL UNIQUE,
  `supplier_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `name` VARCHAR(200) NOT NULL,
  `description` TEXT,
  `sku` VARCHAR(100),
  `unit` VARCHAR(30) DEFAULT 'kg' COMMENT 'kg, pcs, liter, karton, dll',
  `price_per_unit` BIGINT NOT NULL COMMENT 'Harga per satuan',
  `min_order_qty` INT DEFAULT 1,
  `current_stock` INT DEFAULT 0,
  `stock_status` ENUM('aman', 'menipis', 'habis') DEFAULT 'aman',
  `expiry_date` DATE,
  `quality_grade` ENUM('premium', 'grade_a', 'grade_b', 'standart') DEFAULT 'grade_b',
  `is_active` BOOLEAN DEFAULT TRUE,
  `rating` DECIMAL(3,2) DEFAULT 0.00,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE,
  KEY `idx_supplier` (`supplier_id`),
  KEY `idx_category` (`category_id`),
  KEY `idx_code` (`code`),
  KEY `idx_sku` (`sku`),
  KEY `idx_is_active` (`is_active`),
  KEY `idx_stock_status` (`stock_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample products
INSERT INTO `products` (`code`, `supplier_id`, `category_id`, `name`, `description`, `sku`, `unit`, `price_per_unit`, `min_order_qty`, `current_stock`, `stock_status`, `quality_grade`, `is_active`, `rating`) VALUES
('PRD-001', 1, 1, 'Beras Medium Cianjur', 'Beras berkualitas premium dari Cianjur', 'BR-MED-001', 'kg', 12500, 50, 500, 'aman', 'premium', TRUE, 4.8),
('PRD-002', 2, 2, 'Telur Ayam Negeri', 'Telur ayam segar dari peternakan lokal', 'TEL-AYM-001', 'kg', 28000, 25, 200, 'aman', 'grade_a', TRUE, 4.7),
('PRD-003', 3, 3, 'Bayam Segar', 'Bayam organik tanpa pestisida', 'BYM-ORG-001', 'kg', 15000, 10, 85, 'menipis', 'grade_a', TRUE, 4.5),
('PRD-004', 1, 1, 'Jagung Pipil Kering', 'Jagung pipil kering untuk berbagai olahan', 'JGM-PIP-001', 'kg', 8000, 100, 45, 'menipis', 'grade_b', TRUE, 4.3),
('PRD-005', 4, 5, 'Susu UHT Murni', 'Susu UHT full cream premium', 'SUS-UHT-001', 'liter', 16000, 50, 350, 'aman', 'grade_a', TRUE, 4.6),
('PRD-006', 1, 2, 'Kedelai Impor Grade A', 'Kedelai berkualitas impor', 'KDL-IMP-001', 'kg', 14200, 100, 0, 'habis', 'premium', TRUE, 4.4),
('PRD-007', 3, 3, 'Kangkung Segar', 'Kangkung hijau segar setiap hari', 'KNG-SGR-001', 'ikat', 8000, 20, 150, 'aman', 'grade_a', TRUE, 4.5),
('PRD-008', 5, 1, 'Beras IR64', 'Beras IR64 standar untuk konsumsi sehari-hari', 'BR-IR64-001', 'kg', 10000, 75, 800, 'aman', 'standart', TRUE, 4.2);

-- ===================================================================
-- 7. TABEL ORDERS (Pesanan/Transaksi)
-- ===================================================================
CREATE TABLE `orders` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `order_number` VARCHAR(50) NOT NULL UNIQUE,
  `sppg_id` INT NOT NULL,
  `supplier_id` INT NOT NULL,
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `required_date` DATE,
  `delivery_date` DATE,
  `subtotal` BIGINT NOT NULL,
  `tax_amount` BIGINT DEFAULT 0,
  `shipping_cost` BIGINT DEFAULT 0,
  `total_amount` BIGINT NOT NULL,
  `payment_method` ENUM('transfer_bank', 'kartu_kredit', 'cek', 'giro', 'cash') DEFAULT 'transfer_bank',
  `payment_status` ENUM('belum_bayar', 'sebagian', 'lunas', 'kembali') DEFAULT 'belum_bayar',
  `payment_date` DATETIME,
  `order_status` ENUM('draft', 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'rejected') DEFAULT 'pending',
  `created_by` INT,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`sppg_id`) REFERENCES `sppg`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  KEY `idx_order_number` (`order_number`),
  KEY `idx_sppg` (`sppg_id`),
  KEY `idx_supplier` (`supplier_id`),
  KEY `idx_order_status` (`order_status`),
  KEY `idx_payment_status` (`payment_status`),
  KEY `idx_order_date` (`order_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample orders
INSERT INTO `orders` (`order_number`, `sppg_id`, `supplier_id`, `order_date`, `required_date`, `delivery_date`, `subtotal`, `tax_amount`, `shipping_cost`, `total_amount`, `payment_status`, `order_status`, `created_by`, `notes`) VALUES
('ORD-2024-001', 1, 1, '2024-10-01 08:30:00', '2024-10-05', '2024-10-05', 6250000, 625000, 125000, 7000000, 'lunas', 'delivered', 1, 'Pesanan beras untuk kebutuhan gizi minggu ke-1'),
('ORD-2024-002', 1, 2, '2024-10-02 09:15:00', '2024-10-06', '2024-10-06', 1400000, 140000, 50000, 1590000, 'lunas', 'delivered', 1, 'Telur ayam untuk menu protein'),
('ORD-2024-003', 2, 5, '2024-10-08 10:45:00', '2024-10-10', NULL, 8000000, 800000, 200000, 9000000, 'lunas', 'shipped', 2, 'Susu untuk program nutrisi'),
('ORD-2024-004', 1, 3, '2024-10-10 11:20:00', '2024-10-12', NULL, 150000, 15000, 25000, 190000, 'sebagian', 'processing', 1, 'Sayuran segar untuk mingguan'),
('ORD-2024-005', 3, 4, '2024-10-15 14:30:00', '2024-10-17', NULL, 5000000, 500000, 150000, 5650000, 'belum_bayar', 'pending', 3, NULL),
('ORD-2024-006', 2, 1, '2024-10-18 08:00:00', '2024-10-22', NULL, 7500000, 750000, 200000, 8450000, 'belum_bayar', 'confirmed', 2, 'Pesanan rutin bulanan');

-- ===================================================================
-- 8. TABEL ORDER_ITEMS (Detail Item Pesanan)
-- ===================================================================
CREATE TABLE `order_items` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `unit_price` BIGINT NOT NULL,
  `subtotal` BIGINT NOT NULL,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE RESTRICT,
  KEY `idx_order` (`order_id`),
  KEY `idx_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample order items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`, `notes`) VALUES
(1, 1, 500, 12500, 6250000, 'Beras 500kg'),
(2, 2, 50, 28000, 1400000, 'Telur 50kg'),
(3, 5, 500, 16000, 8000000, 'Susu UHT 500 liter'),
(4, 3, 10, 15000, 150000, 'Bayam 10kg'),
(5, 5, 312, 16000, 5000000, 'Susu premium 312 liter'),
(6, 1, 600, 12500, 7500000, 'Beras bulanan 600kg');

-- ===================================================================
-- 9. TABEL INVOICES (Invoice)
-- ===================================================================
CREATE TABLE `invoices` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `invoice_number` VARCHAR(50) NOT NULL UNIQUE,
  `order_id` INT NOT NULL,
  `invoice_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `due_date` DATE,
  `paid_date` DATETIME,
  `amount` BIGINT NOT NULL,
  `paid_amount` BIGINT DEFAULT 0,
  `status` ENUM('draft', 'sent', 'partial', 'paid', 'overdue', 'cancelled') DEFAULT 'draft',
  `payment_method` VARCHAR(50),
  `reference_number` VARCHAR(100),
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE RESTRICT,
  KEY `idx_invoice_number` (`invoice_number`),
  KEY `idx_order` (`order_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample invoices
INSERT INTO `invoices` (`invoice_number`, `order_id`, `invoice_date`, `due_date`, `paid_date`, `amount`, `paid_amount`, `status`, `payment_method`, `reference_number`) VALUES
('INV/2024/10/001', 1, '2024-10-01', '2024-10-08', '2024-10-05', 7000000, 7000000, 'paid', 'transfer_bank', 'TRF-BCA-001'),
('INV/2024/10/002', 2, '2024-10-02', '2024-10-09', '2024-10-06', 1590000, 1590000, 'paid', 'transfer_bank', 'TRF-BCA-002'),
('INV/2024/10/003', 3, '2024-10-08', '2024-10-15', NULL, 9000000, 0, 'sent', NULL, NULL),
('INV/2024/10/004', 4, '2024-10-10', '2024-10-17', '2024-10-12', 190000, 95000, 'partial', 'transfer_bank', 'TRF-BCA-003'),
('INV/2024/10/005', 5, '2024-10-15', '2024-10-22', NULL, 5650000, 0, 'sent', NULL, NULL),
('INV/2024/10/006', 6, '2024-10-18', '2024-10-25', NULL, 8450000, 0, 'draft', NULL, NULL);

-- ===================================================================
-- 10. TABEL SHIPMENTS (Pengiriman)
-- ===================================================================
CREATE TABLE `shipments` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `shipment_number` VARCHAR(50) NOT NULL UNIQUE,
  `order_id` INT NOT NULL,
  `shipment_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `expected_delivery_date` DATE,
  `actual_delivery_date` DATETIME,
  `shipping_method` ENUM('internal_courier', 'jne', 'jnt', 'tiki', 'pos', 'custom') DEFAULT 'internal_courier',
  `tracking_number` VARCHAR(100),
  `origin_location` VARCHAR(200),
  `destination_location` VARCHAR(200),
  `status` ENUM('pending', 'dikemas', 'dikirim', 'dalam_transit', 'tiba', 'diterima', 'gagal') DEFAULT 'pending',
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  KEY `idx_shipment_number` (`shipment_number`),
  KEY `idx_order` (`order_id`),
  KEY `idx_status` (`status`),
  KEY `idx_shipment_date` (`shipment_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample shipments
INSERT INTO `shipments` (`shipment_number`, `order_id`, `shipment_date`, `expected_delivery_date`, `actual_delivery_date`, `shipping_method`, `tracking_number`, `origin_location`, `destination_location`, `status`, `notes`) VALUES
('DEL-2024-001', 1, '2024-10-02 09:00:00', '2024-10-05', '2024-10-05 14:30:00', 'internal_courier', 'TRK-001', 'Gudang Surabaya', 'SPPG Surabaya Barat', 'diterima', NULL),
('DEL-2024-002', 2, '2024-10-03 10:00:00', '2024-10-06', '2024-10-06 16:00:00', 'jnt', 'JNT-2024-0001', 'Bandung', 'SPPG Surabaya Timur', 'diterima', NULL),
('DEL-2024-003', 3, '2024-10-09 08:30:00', '2024-10-12', NULL, 'jne', 'JNE-2024-0001', 'Gresik', 'SPPG Jakarta', 'dalam_transit', NULL),
('DEL-2024-004', 4, '2024-10-11 07:00:00', '2024-10-12', NULL, 'internal_courier', 'TRK-002', 'Pasar Pon', 'SPPG Surabaya Barat', 'dikemas', NULL),
('DEL-2024-005', 5, '2024-10-19 06:00:00', '2024-10-21', NULL, 'jne', 'JNE-2024-0002', 'Mojokerto', 'SPPG Sidoarjo', 'dikirim', NULL),
('DEL-2024-006', 6, '2024-10-20 10:30:00', '2024-10-23', NULL, 'internal_courier', 'TRK-003', 'Gudang Surabaya', 'SPPG Surabaya Timur', 'pending', NULL);

-- ===================================================================
-- 11. TABEL STOCK (Stok Produk)
-- ===================================================================
CREATE TABLE `stock` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `product_id` INT NOT NULL UNIQUE,
  `warehouse_location` VARCHAR(150),
  `quantity_on_hand` INT DEFAULT 0,
  `quantity_reserved` INT DEFAULT 0,
  `quantity_available` INT DEFAULT 0 GENERATED ALWAYS AS (quantity_on_hand - quantity_reserved) STORED,
  `reorder_level` INT DEFAULT 100 COMMENT 'Minimum stok sebelum reorder',
  `reorder_quantity` INT DEFAULT 500 COMMENT 'Jumlah untuk reorder',
  `last_restock_date` DATETIME,
  `expiry_date` DATE,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  KEY `idx_product` (`product_id`),
  KEY `idx_quantity_available` (`quantity_available`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample stock
INSERT INTO `stock` (`product_id`, `warehouse_location`, `quantity_on_hand`, `quantity_reserved`, `reorder_level`, `reorder_quantity`) VALUES
(1, 'Gudang A - Rak 1', 500, 100, 200, 500),
(2, 'Gudang A - Rak 3', 200, 50, 50, 200),
(3, 'Gudang B - Rak 2', 85, 20, 100, 150),
(4, 'Gudang A - Rak 5', 45, 0, 150, 500),
(5, 'Gudang C - Ruang Pendingin', 350, 50, 100, 300),
(6, 'Gudang A - Rak 7', 0, 0, 200, 500),
(7, 'Gudang B - Rak 1', 150, 30, 100, 200),
(8, 'Gudang A - Rak 2', 800, 150, 300, 600);

-- ===================================================================
-- 12. TABEL BUDGET (Anggaran SPPG)
-- ===================================================================
CREATE TABLE `budget` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `sppg_id` INT NOT NULL,
  `year` YEAR NOT NULL,
  `month` TINYINT,
  `allocation_type` ENUM('annual', 'quarterly', 'monthly') DEFAULT 'monthly',
  `total_budget` BIGINT NOT NULL,
  `used_amount` BIGINT DEFAULT 0,
  `reserved_amount` BIGINT DEFAULT 0,
  `remaining` BIGINT GENERATED ALWAYS AS (total_budget - used_amount - reserved_amount) STORED,
  `percentage_used` DECIMAL(5,2) GENERATED ALWAYS AS ((used_amount / total_budget) * 100) STORED,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`sppg_id`) REFERENCES `sppg`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_sppg_year_month` (`sppg_id`, `year`, `month`),
  KEY `idx_sppg` (`sppg_id`),
  KEY `idx_year` (`year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample budget
INSERT INTO `budget` (`sppg_id`, `year`, `month`, `allocation_type`, `total_budget`, `used_amount`, `reserved_amount`, `notes`) VALUES
(1, 2024, 10, 'monthly', 42000000, 15000000, 10000000, 'Anggaran bulanan Oktober'),
(1, 2024, 11, 'monthly', 42000000, 0, 0, 'Anggaran bulanan November'),
(2, 2024, 10, 'monthly', 62500000, 25000000, 15000000, 'Anggaran bulanan Oktober'),
(3, 2024, 10, 'monthly', 33333333, 8000000, 5000000, 'Anggaran bulanan Oktober'),
(4, 2024, 10, 'monthly', 66666667, 20000000, 10000000, 'Anggaran bulanan Oktober');

-- ===================================================================
-- 13. TABEL AUDIT_LOGS (Jejak Audit)
-- ===================================================================
CREATE TABLE `audit_logs` (
  `id` BIGINT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT,
  `action` VARCHAR(150) NOT NULL,
  `entity_type` VARCHAR(100) COMMENT 'order, product, user, etc',
  `entity_id` INT,
  `old_value` JSON,
  `new_value` JSON,
  `ip_address` VARCHAR(45),
  `user_agent` TEXT,
  `status` ENUM('success', 'failed', 'warning') DEFAULT 'success',
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  KEY `idx_user` (`user_id`),
  KEY `idx_entity` (`entity_type`, `entity_id`),
  KEY `idx_action` (`action`),
  KEY `idx_created` (`created_at`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample audit logs
INSERT INTO `audit_logs` (`user_id`, `action`, `entity_type`, `entity_id`, `ip_address`, `status`, `description`, `created_at`) VALUES
(1, 'LOGIN', 'user', 1, '192.168.1.1', 'success', 'Login user admin_pusat', NOW() - INTERVAL 30 MINUTE),
(2, 'VIEW_REPORT', 'report', 1, '192.168.1.50', 'success', 'Auditor melihat laporan REP-2024-07-01', NOW() - INTERVAL 15 MINUTE),
(3, 'CREATE_ORDER', 'order', 5, '192.168.1.100', 'success', 'Membuat pesanan baru #ORD-2024-005', NOW() - INTERVAL 5 MINUTE),
(4, 'UPDATE_PRODUCT', 'product', 1, '192.168.1.101', 'success', 'Update stok produk beras', NOW() - INTERVAL 2 MINUTE),
(1, 'APPROVE_SUPPLIER', 'supplier', 5, '192.168.1.1', 'success', 'Verifikasi supplier Koperasi Berkah Tani', '2024-03-10 10:30:00'),
(2, 'DOWNLOAD_INVOICE', 'invoice', 1, '192.168.1.50', 'success', 'Download invoice INV/2024/10/001', '2024-10-05 14:20:00');

-- ===================================================================
-- 14. TABEL REPORTS (Laporan)
-- ===================================================================
CREATE TABLE `reports` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `report_code` VARCHAR(50) NOT NULL UNIQUE,
  `report_title` VARCHAR(255) NOT NULL,
  `report_type` ENUM('bulanan', 'quartalan', 'tahunan', 'insidental', 'otomatis') DEFAULT 'bulanan',
  `period_start` DATE,
  `period_end` DATE,
  `generated_by` INT,
  `generated_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('draft', 'finalized', 'approved', 'archived') DEFAULT 'draft',
  `file_path` VARCHAR(255),
  `description` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`generated_by`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  KEY `idx_report_code` (`report_code`),
  KEY `idx_report_type` (`report_type`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample reports
INSERT INTO `reports` (`report_code`, `report_title`, `report_type`, `period_start`, `period_end`, `generated_by`, `status`, `description`) VALUES
('REP-2024-07-01', 'Rekapitulasi Bulanan Nasional - Juli', 'bulanan', '2024-07-01', '2024-07-31', 2, 'finalized', 'Laporan agregat seluruh SPPG dan Supplier untuk bulan Juli'),
('REP-2024-08-01', 'Rekapitulasi Bulanan Nasional - Agustus', 'bulanan', '2024-08-01', '2024-08-31', 2, 'finalized', 'Laporan agregat seluruh SPPG dan Supplier untuk bulan Agustus'),
('REP-2024-Q3', 'Laporan Kuartalan Q3 2024', 'quartalan', '2024-07-01', '2024-09-30', 2, 'approved', 'Laporan performa kuartal 3 tahun 2024'),
('AUDIT-2024-SP-01', 'Audit Khusus SPPG Surabaya Barat', 'insidental', '2024-09-15', '2024-09-30', 2, 'draft', 'Audit khusus terkait penyimpangan pesanan');

-- ===================================================================
-- 15. TABEL NOTIFICATIONS (Notifikasi)
-- ===================================================================
CREATE TABLE `notifications` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `message` TEXT NOT NULL,
  `type` ENUM('info', 'warning', 'error', 'success') DEFAULT 'info',
  `category` VARCHAR(50) COMMENT 'order, payment, shipment, system, etc',
  `related_entity_type` VARCHAR(100),
  `related_entity_id` INT,
  `is_read` BOOLEAN DEFAULT FALSE,
  `read_at` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  KEY `idx_user` (`user_id`),
  KEY `idx_is_read` (`is_read`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample notifications
INSERT INTO `notifications` (`user_id`, `title`, `message`, `type`, `category`, `related_entity_type`, `related_entity_id`, `is_read`, `created_at`) VALUES
(1, 'Stok Beras Menipis', 'Persediaan beras di gudang sisa 250kg. Segera buat pesanan baru.', 'warning', 'stock', 'product', 1, FALSE, NOW() - INTERVAL 5 MINUTE),
(1, 'Pengiriman Sedang Jalan', 'Pesanan #ORD-9821 sedang dalam perjalanan oleh Supplier Sembako Jaya.', 'info', 'shipment', 'order', 3, FALSE, NOW() - INTERVAL 1 HOUR),
(1, 'Budget Disetujui', 'Penambahan anggaran operasional minggu ke-3 telah disetujui pusat.', 'success', 'budget', 'budget', 1, TRUE, NOW() - INTERVAL 3 HOUR),
(2, 'Invoice Menunggu', 'Invoice INV/2024/10/003 untuk pesanan #ORD-2024-003 telah dibuat.', 'info', 'payment', 'invoice', 3, FALSE, NOW() - INTERVAL 2 DAY),
(3, 'Pesanan Baru Masuk', 'Pesanan baru #ORD-2024-005 telah diterima dari SPPG Sidoarjo.', 'success', 'order', 'order', 5, FALSE, NOW() - INTERVAL 1 DAY),
(4, 'Pesanan Siap Dikirim', 'Pesanan #ORD-2024-001 siap dikirim, harap segera ambil di gudang.', 'info', 'order', 'order', 1, TRUE, NOW() - INTERVAL 2 DAY);

-- ===================================================================
-- INDEX TAMBAHAN UNTUK OPTIMASI
-- ===================================================================
CREATE INDEX idx_orders_created_date ON orders(created_at);
CREATE INDEX idx_products_supplier_category ON products(supplier_id, category_id);
CREATE INDEX idx_stock_available ON stock(quantity_available);
CREATE INDEX idx_shipments_order_status ON shipments(order_id, status);
CREATE INDEX idx_invoices_order_date ON invoices(order_id, invoice_date);
CREATE INDEX idx_audit_logs_entity ON audit_logs(entity_type, entity_id, created_at);

-- ===================================================================
-- VIEWS UNTUK QUERY UMUM
-- ===================================================================

-- View: Ringkasan Order dengan Info SPPG & Supplier
CREATE VIEW v_order_summary AS
SELECT 
    o.id,
    o.order_number,
    s.name AS sppg_name,
    s.code AS sppg_code,
    sup.name AS supplier_name,
    o.order_date,
    o.total_amount,
    o.payment_status,
    o.order_status,
    COUNT(oi.id) AS item_count,
    SUM(oi.quantity) AS total_quantity
FROM orders o
JOIN sppg s ON o.sppg_id = s.id
JOIN suppliers sup ON o.supplier_id = sup.id
LEFT JOIN order_items oi ON o.id = oi.order_id
GROUP BY o.id;

-- View: Performa Supplier
CREATE VIEW v_supplier_performance AS
SELECT 
    sup.id,
    sup.code,
    sup.name,
    COUNT(DISTINCT o.id) AS total_orders,
    SUM(o.total_amount) AS total_sales,
    AVG(sup.rating) AS avg_rating,
    COUNT(CASE WHEN o.order_status = 'delivered' THEN 1 END) AS completed_orders,
    COUNT(CASE WHEN o.order_status = 'cancelled' THEN 1 END) AS cancelled_orders
FROM suppliers sup
LEFT JOIN orders o ON sup.id = o.supplier_id
GROUP BY sup.id;

-- View: Penggunaan Budget SPPG
CREATE VIEW v_sppg_budget_usage AS
SELECT 
    s.id,
    s.code,
    s.name,
    b.year,
    b.month,
    b.total_budget,
    b.used_amount,
    b.reserved_amount,
    b.remaining,
    b.percentage_used
FROM sppg s
LEFT JOIN budget b ON s.id = b.sppg_id
ORDER BY b.year DESC, b.month DESC;

-- View: Stok Produk yang Perlu Restock
CREATE VIEW v_products_need_restock AS
SELECT 
    p.id,
    p.code,
    p.name,
    st.quantity_available,
    st.reorder_level,
    st.reorder_quantity,
    CASE 
        WHEN st.quantity_available <= 0 THEN 'HABIS'
        WHEN st.quantity_available <= st.reorder_level THEN 'PERLU_RESTOCK'
        ELSE 'AMAN'
    END AS stock_status
FROM products p
JOIN stock st ON p.id = st.product_id
WHERE st.quantity_available <= st.reorder_level
ORDER BY st.quantity_available ASC;

-- ===================================================================
-- TRIGGERS UNTUK AUTOMASI
-- ===================================================================

-- Trigger: Update stock ketika order items dibuat
DELIMITER //
CREATE TRIGGER tr_update_stock_on_order_item
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE stock 
    SET quantity_reserved = quantity_reserved + NEW.quantity
    WHERE product_id = NEW.product_id;
    
    UPDATE products 
    SET stock_status = CASE 
        WHEN (SELECT quantity_available FROM stock WHERE product_id = NEW.product_id) <= 0 THEN 'habis'
        WHEN (SELECT quantity_available FROM stock WHERE product_id = NEW.product_id) <= 100 THEN 'menipis'
        ELSE 'aman'
    END
    WHERE id = NEW.product_id;
END //
DELIMITER ;

-- Trigger: Hitung ulang order total saat order items diupdate
DELIMITER //
CREATE TRIGGER tr_update_order_total
AFTER INSERT ON order_items
FOR EACH ROW
BEGIN
    UPDATE orders 
    SET subtotal = (SELECT SUM(subtotal) FROM order_items WHERE order_id = NEW.order_id),
        total_amount = (SELECT SUM(subtotal) FROM order_items WHERE order_id = NEW.order_id) + IFNULL(tax_amount, 0) + IFNULL(shipping_cost, 0)
    WHERE id = NEW.order_id;
END //
DELIMITER ;

-- Trigger: Create audit log untuk setiap perubahan order
DELIMITER //
CREATE TRIGGER tr_audit_log_order_update
AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF OLD.order_status != NEW.order_status OR OLD.payment_status != NEW.payment_status THEN
        INSERT INTO audit_logs (user_id, action, entity_type, entity_id, old_value, new_value, status, description)
        VALUES (
            NULL,
            'UPDATE_ORDER',
            'order',
            NEW.id,
            JSON_OBJECT('status', OLD.order_status, 'payment_status', OLD.payment_status),
            JSON_OBJECT('status', NEW.order_status, 'payment_status', NEW.payment_status),
            'success',
            CONCAT('Order ', NEW.order_number, ' status changed from ', OLD.order_status, ' to ', NEW.order_status)
        );
    END IF;
END //
DELIMITER ;

-- ===================================================================
-- INFORMASI SISTEM
-- ===================================================================
-- Database: mbgfix
-- Tables: 15 (roles, users, sppg, suppliers, categories, products, orders, order_items, 
--         invoices, shipments, stock, budget, audit_logs, reports, notifications)
-- Views: 4
-- Triggers: 3
-- Charset: UTF8MB4
-- Collation: UTF8MB4_unicode_ci
-- ===================================================================

-- Selesai: Database setup siap digunakan!
-- Pastikan untuk mengubah password di file config.php sebelum production
