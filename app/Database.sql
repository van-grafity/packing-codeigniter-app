--
-- Database: 
--
-- --------------------------------------------------------
--
-- Struktur dari tabel `category`
--
CREATE TABLE `category` (
    `category_id` int(11) NOT NULL,
    `category_name` varchar(50) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
--
-- Dumping data untuk tabel `category`
--
INSERT INTO `category` (`category_id`, `category_name`)
VALUES (1, 'T-Shirt'),
    (2, 'Polo Shirt'),
    (3, 'Legging'),
    (4, 'Dress');
-- --------------------------------------------------------
--
-- Struktur dari tabel `product`
--
CREATE TABLE `product` (
    `product_id` int(11) NOT NULL,
    `product_name` varchar(100) DEFAULT NULL,
    `product_price` int(11) DEFAULT NULL,
    `product_category_id` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;