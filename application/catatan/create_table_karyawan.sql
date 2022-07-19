create table karyawan (
	id int primary key not null,
	level int not null,
	nik varchar(6) not null,
	atasan varchar(50),
	nama varchar(50),
	wilayah varchar(10),
	kordinator varchar(5),
	marketing varchar(5),
	jabatan	varchar(25),
	status tinyint
)

create table unit_karyawan (
	id int primary key not null,
	id_karyawan int not null,
	unit varchar(5) not null,

	foreign key (id_karyawan) references karyawan(id)
)