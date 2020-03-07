<!-- Perubahan script coding untuk bisa menampilkan about dalam bentuk tampilan bootstrap (AdminLTE)  -->
<div class="box-header with-border">
	<h3 class="box-title"><strong>Anda sedang menggunakan aplikasi OpenSID <?= AmbilVersi()?></strong></h3>
</div>
<div class="box-body">
	<div class="box-group" id="accordion">
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Aplikasi OpenSID</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse in">
				<div class="box-body">
					<p>OpenSID adalah aplikasi Sistem Informasi Desa (SID) yang dikembangkan sejak Mei 2016. OpenSID dirancang dan dikelola supaya terbuka dan dapat dikembangkan bersama-sama oleh komunitas peduli SID. Informasi lebih lanjut dapat dilihat di <a href= https://github.com/OpenSID/opensid>https://github.com/OpenSID/opensid</a>.</p>
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Apakah SID ?</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div class="box-body">
					<p>Aplikasi Sistem Informasi Desa (SID) adalah sistem olah data dan informasi berbasis komputer yang dapat dikelola oleh pemerintah dan komunitas desa dalam dua ranah:</p>
					<dl>
						<dt>1. Offline</dt>
						<dd>Aplikasi diinstall dalam komputer server di kantor desa dan dioperasikan sebagai server (pusat data) yang bersifat lokal. Karena tidak terhubung ke internet, SID offline hanya bisa diakses dalam jaringan lokal. Sistem offline ini direkomendasikan untuk diterapkan dalam penggunaan aplikasi SID harian. Database dari hasil proses olah data secara offline itu dapat diunggah ke sistem online secara berkala.</dd>						<dt>2. Online</dt>
						<dd>SID akan optimal jika terhubung ke internet sebagai sistem online berbasis web. SID online akan otomatis berfungsi juga sebagai website desa. Website desa ini memiliki fungsi yang terbagi dalam dua bagian, yakni bagian depan yang bisa diakses oleh publik dan bagian dalam yang hanya bisa diakses oleh administrator sistem.</dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Manajemen Akses SID</a>
				</h4>
			</div>
			<div id="collapse3" class="panel-collapse collapse">
				<div class="box-body">
					<p>Aplikasi SID dirancang untuk mengelola data dasar desa dan informasi desa. Data dasar yang dikelola meliputi data dasar kependudukan dan data dasar aset/sumber daya desa. Data dasar ini menjadi tanggung jawab pemerintah desa dalam pengelolaannya. Hanya pengguna (user) dari pemerintah desa dan tim yang dikoordinasikan oleh pemerintah desa saja yang akan memiliki kewenangan dan hak akses ke dalam sistem. Sementara, user di luar pemerintah desa hanya akan memiliki akses terbatas pada fungsi olah informasi untuk website desa.</p>
					<p>Tingkat user (pengguna) dalam SID:</p>
					<p>
						<ol>
							<li>
								Administrator : adalah orang/tim yang bertanggung jawab penuh atas olah data dan informasi dalam SID dan website desa. Orang/tim ini ditunjuk oleh pemerintah desa disahkan dengan surat keputusan kepala desa.
								<ol>
									<li>Peran olah data : entry, edit, delete data dasar</li>
									<li>Peran olah informasi : tulis, edit, publish artikel website</li>
								</ol>
							</li>
							<li>
								Operator: adalah orang/tim yang bertugas membantu administrator mengelola data dan informasi, tetapi dengan kewenangan yang lebih terbatas.
								<ol>
									<li>Peran olah data : entry, edit data dasar</li>
									<li>Peran olah informasi : tulis, edit artikel website.</li>
								</ol>
							</li>
							<li>
								Redaksi: adalah orang/tim yang bertugas sebagai redaksi media website desa dan hanya dapat melakukan olah informasi berupa artikel website.
								<ol>
									<li>Peran olah informasi : tulis, edit artikel. Redaksi boleh mengubah semua artikel, termasuk menjadikan headline, aktif/non-aktifkan, masukkan ke slider, dsbnya</li>
								</ol>
							</li>
							<li>
								Kontributor: adalah orang/tim yang bertugas menulis artikel untuk disetujui redaksi untuk ditampilkan di website desa.
								<ol>
									<li>Peran olah informasi : tulis, edit artikel yang dibuatnya sendiri. Kontributor tidak dapat menjadikan artikel manapun menjadi headline, aktif/non-aktifkan atau memasukkan ke slider.</li>
								</ol>
							</li>
						</ol>
					</p>
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Tahapan Membangun SID</a>
				</h4>
			</div>
			<div id="collapse4" class="panel-collapse collapse">
				<div class="box-body">
					<P>Bagaimana memulai membangun Sistem Informasi Desa (SID) di desa kita? Caranya sangat mudah, tetapi pasti perlu proses yang harus sabar dan cermat untuk dijalani. Siapa pun Anda, baik perorangan maupun mewakili organisasi/lembaga, dapat mencoba mulai membangun SID di desa masing-masing mengikuti langkah-langkah berikut.</P>
					<ol>
						<li>Bentuk tim kerja bersama pemerintah desa</li>
						<li>Diskusikan basis data apa saja yang diperlukan untuk warga</li>
						<li>Himpun data kependudukan warga dari Kartu Keluarga (KK)</li>
						<li>Dapatkan aplikasi softwarenya di https://github.com/OpenSID/OpenSID/releases</li>
						<li>Install aplikasi software SID di komputer desa</li>
						<li>Entry data penduduk ke SID</li>
						<li>Basis data kependudukan sudah bisa dimanfaatkan</li>
						<li>Diskusikan rencana pengembangan SID sesuai kebutuhan desa</li>
						<li>Sebarluaskan informasi desa melalui beragam media untuk warga</li>
					</ol>
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Hak Cipta, Syarat, Dan Ketentuan</a>
				</h4>
			</div>
			<div id="collapse5" class="panel-collapse collapse">
				<div class="box-body">
					<p>Aplikasi Sistem Informasi Desa (SID) dibangun dan dikembangkan pada awalnya oleh COMBINE Resource Institution sejak tahun 2009. Sistem ini dikelola dengan merujuk pada lisensi GNU General Public License Version 3.</p>
					<p>Dengan lisensi GPL v3, semua ubahan OpenSID juga berlisensi GPL v3, yaitu bersifat sumber terbuka.<p>
					<p>OpenSID dikembangkan sejak Mei 2016, dan bebas untuk dimanfaatkan dan dikembangkan oleh semua desa.</p>
					<p>Sejak Januari 2019, OpenSID dikelola oleh Perkumpulan Desa Digital Terbuka (OpenDesa). OpenDesa adalah pemegang hak cipta utama OpenSID.
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse6">Kontak Dan Informasi</a>
				</h4>
			</div>
			<div id="collapse6" class="panel-collapse collapse">
				<div class="box-body">
					<ol>
						<li>Website OpenDesa, pengelola OpenSID: </li>
						<a href="http://opendesa.id/" target="_blank">http://opendesa.id </a>
						<li>Website resmi OpenSID: </li>
						<a href="http://opensid.my.id/" target="_blank">http://opensid.my.id </a>
						<li>Group Facebook, tempat mendapatkan bantuan dan berbagi pengalaman: </li>
						<a href="https://www.facebook.com/groups/opensid/" target="_blank">Forum Pengguna dan Pegiat OpenSID </a>
						<li>Tempat mengunduh rilis OpenSID:</li>
						<a href="https://github.com/OpenSID/OpenSID/releases" target="_blank">https://github.com/OpenSID/OpenSID/releases </a>
						<li>Panduan OpenSID:</li>
						<a href="https://github.com/OpenSID/OpenSID/wiki" target="_blank">https://github.com/OpenSID/OpenSID/wiki </a>
						<li>Channel Youtube OpenSID: </li>
						<a href="https://www.youtube.com/channel/UCvZuSYtrWYuE8otM4SsdT0Q" target="_blank">Kumpulan tutorial video OpenSID </a>
						<li>Repository (tempat pengelolaan) OpenSID:</li>
						<a href="https://github.com/OpenSID/OpenSID" target="_blank">https://github.com/OpenSID/OpenSID </a>
						<li>Tempat mendaftarkan masalah dan usulan fitur:</li>
						<a href="https://github.com/OpenSID/OpenSID/issues" target="_blank" sclass="text-green">https://github.com/OpenSID/OpenSID/issues </a>
						<li>Forum diskusi teknis pengembangan OpenSID:</li>
						<a href="https://opensid.slack.com" target="_blank">https://opensid.slack.com </a>
					</ol>
				</div>
			</div>
		</div>
		<div class="panel box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#donasi">Donasi</a>
				</h4>
			</div>
			<div id="donasi" class="panel-collapse collapse">
				<div class="box-body">
					<h4>OpenSID SELALU GRATIS</h4>
					<div>
						<p>OpenSID selalu gratis dan bebas digunakan dan dikembangkan desa. OpenSID berlisensi GNU General Public License Version 3, yaitu Open Source, di mana scriptnya selalu bebas diperoleh dan disesuaikan desa.</p>
					</div>
					<h4>OpenSID DIKEMBANGKAN KOMUNITAS</h4>
					<div>
						<p>OpenSID dikembangkan oleh komunitas relawan yang peduli dan meluangkan waktu dan keahlian mereka secara sukarela untuk terus mengembangkan OpenSID.</p>
						<p>Selain menyumbangkan waktu mereka, ada kalanya relawan OpenSID juga mengeluarkan dana pribadi untuk mendukung kegiatan OpenSID.</p>
					</div>
					<h4>OpenSID MEMERLUKAN BANTUAN</h4>
					<div>
						<p>Untuk terus berkembang, OpenSID memerlukan bantuan komunitas SID, termasuk donasi. Semua donasi bersifat sukarela dan sama sekali tidak ada keharusan. </p>
						<p>Donasi anda akan memungkinkan OpenSID dikembangkan terus secara berkesinambungan, supaya bisa terus disempurnakan dan bisa dimanfaatkan oleh sebanyak mungkin desa di seluruh Nusantara. </p>
						<p>
							Cara mengirimkan donasi dan informasi lebih lanjut ada di:
						</p>
						<a href="https://www.opendesa.id/donasi" class="btn btn-social btn-flat btn-primary btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block" title="Kembali Ke Daftar Suplemen"><i class="fa fa-heart"></i> Donasi Pengembangan OpenSID</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="box-header with-border"></div>
</div>