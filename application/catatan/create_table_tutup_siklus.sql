create table tutup_siklus (
	id int primary key identity not null,
	noreg varchar(15) not null,
	tgl_docin date,
	tgl_tutup date
)