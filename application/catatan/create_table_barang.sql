create table barang (
	id int primary key identity,
	kode varchar(10),
	kode_suplier varchar(10),
	kategori varchar(50),
	nama varchar(200),
	umur varchar(10),
	berat decimal(8,2),
	bentuk varchar(25),
	isi decimal(8,2),
	simpan int,
	qty	int,
	g_status int
)