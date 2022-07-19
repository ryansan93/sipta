create table gudang (
	id int primary key identity not null,
	nama varchar(50),
	alamat varchar(100),
	penanggung_jawab varchar(50)
)

alter table gudang add jenis varchar(10)