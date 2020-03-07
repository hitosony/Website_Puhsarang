<div class="panel">
          <div class="header">
            <h4 class="title">Arsip Konten Situs Web <?=$desa["nama_desa"]?></h4>
          </div>
<?php if(count($farsip)>0): ?>
				<table class="table table-striped mt-5">
					<thead>
						<tr>
							<td width="3%"><b>No.</b></td>
							<td width="20%"><b>Tanggal Artikel</b></td>
							<td><b>Judul Artikel</b></td>
							<td width="20%"><b>Penulis</b></td>
						</tr>
					</thead>
					<tbody>
					<?php foreach($farsip AS $data): ?>
						<tr>
							<td style="text-align:center;">
								<?= $data["no"]?>
							</td>
							<td>
								<?= tgl_indo($data["tgl_upload"])?>
							</td>
							<td>
								<a href="<?= site_url('first/artikel/'.$data[id])?>"><?= $data["judul"]?></a>
							</td>
							<td style="text-align:center;">
								<?= $data["owner"]?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				Belum ada arsip konten web.
			<?php endif; ?>
		</div>
		<?php if(count($farsip)>0): ?>
			<div class="box-footer">
				<ul class="pagination pagination-sm no-margin ">
					<?php if($paging->start_link): ?>
						<li><a href="<?= site_url("first/arsip/$paging->start_link")?>" title="Halaman Pertama" class="btn btn-sm btn-primary mr-1"><i class="fa fa-fast-backward"></i>&nbsp;</a></li>
					<?php endif; ?>
					<?php if($paging->prev): ?>
						<li><a href="<?= site_url("first/arsip/$paging->prev")?>" title="Halaman Sebelumnya" class="btn btn-sm btn-primary  mr-1"><i class="fa fa-backward"></i>&nbsp;</a></li>
					<?php endif; ?>
					<?php for ($i=$paging->start_link; $i<=$paging->end_link; $i++): ?>
						<li class="<?php ($p != $i) or print('active');?>"><a class="btn btn-sm btn-primary  mr-1" href="<?=site_url('first/arsip/'.$i)?>" title="<?= 'Halaman '.$i ?>"><?= $i ?></a></li>
					<?php endfor; ?>
					<?php if($paging->next): ?>
						<li><a class="btn btn-sm btn-primary  mr-1" href="<?= site_url("first/arsip/$paging->next")?>" title="Halaman Selanjutnya"><i class="fa fa-forward"></i>&nbsp;</a></li>
					<?php endif; ?>
					<?php if($paging->end_link): ?>
						<li><a class="btn btn-sm btn-primary" href="<?= site_url("first/arsip/$paging->end_link")?>" title="Halaman Terakhir"><i class="fa fa-fast-forward"></i>&nbsp;</a></li>
					<?php endif; ?>
				</ul>
			</div>
		<?php endif; ?>
