<script>
	$(function()
	{
		var keyword = <?= $keyword?> ;
		$( "#cari" ).autocomplete(
		{
			source: keyword,
			maxShowItems: 10,
		});
	});
</script>
<div class="content-wrapper">
	<section class="content-header">
		<h1>Artikel</h1>
		<ol class="breadcrumb">
			<li><a href="<?=site_url('hom_sid')?>"><i class="fa fa-home"></i> Home</a></li>
			<li class="active">Artikel</li>
		</ol>
	</section>
	<section class="content" id="maincontent">
		<form id="mainform" name="mainform" action="" method="post">
			<div class="row">
				<div class="col-md-3">
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Kategori Artikel</h3>
							<div class="box-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body no-padding">
							<ul class="nav nav-pills nav-stacked">
								<?php foreach ($list_kategori AS $data): ?>
									<li class="<?php ($cat == $data['id']) and print('active') ?>">
										<a href='<?=site_url("web/index/$data[id]")?>'>
											<?php if ($data['kategori']!="teks_berjalan"): ?>
												<?= $data['kategori'];?>
											<?php else: ?>
												Teks Berjalan
											<?php endif; ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
					<div class="box box-info">
						<div class="box-header with-border">
							<h3 class="box-title">Artikel Statis</h3>
							<div class="box-tools">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body no-padding">
							<ul class="nav nav-pills nav-stacked">
								<li class="<?php ($cat == 999) and print('active') ?>"><a href="<?=site_url('web/index/999')?>">Halaman Statis</a></li>
       					<li class="<?php ($cat == 1000) and print('active') ?>"><a href="<?=site_url('web/index/1000')?>">Agenda</a></li>
       					<li class="<?php ($cat == 1001) and print('active') ?>"><a href="<?=site_url('web/index/1001')?>">Keuangan</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="box box-info">
            <div class="box-header with-border">
							<?php if ($cat > 0): ?>
								<a href="<?=site_url("web/form/$cat")?>" class="btn btn-social btn-flat btn-success btn-sm btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"  title="Tambah Artikel">
									<i class="fa fa-plus"></i>Tambah
										<?php if ($kategori): ?>
											<?= $kategori['kategori'];?>
										<?php elseif ($cat == 1000): ?>
											Agenda
										<?php elseif ($cat == 1001): ?>
											Artikel Keuangan
										<?php else: ?>
											Artikel Statis
										<?php endif; ?> Baru
	            				</a>
							<?php endif; ?>
							<?php if ($this->CI->cek_hak_akses('h')): ?>
								<a href="#confirm-delete" title="Hapus Data" onclick="deleteAllBox('mainform', '<?=site_url("web/delete_all/$cat/$p/$o")?>')" class="btn btn-social btn-flat btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Data Terpilih</a>
							<?php endif; ?>
							<?php if ($cat > 0 and $cat < 999): ?>
								<a href="#confirm-delete" title="Hapus Kategori <?=$kategori['kategori']?>" onclick="deleteAllBox('mainform', '<?=site_url("web/hapus/$cat/$p/$o")?>')" class="btn btn-social btn-flat btn-danger btn-sm visible-xs-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block hapus-terpilih"><i class='fa fa-trash-o'></i> Hapus Kategori <?=$kategori['kategori']?></a>
							<?php endif; ?>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="dataTables_wrapper form-inline dt-bootstrap no-footer">
										<form id="mainform" name="mainform" action="" method="post">
											<div class="row">
												<div class="col-sm-6">
													<select class="form-control input-sm " name="filter" onchange="formAction('mainform', '<?=site_url("web/filter/$cat")?>')">
														<option value="">Semua</option>
														<option value="1" <?php selected($filter, 1); ?>>Aktif</option>
														<option value="2" <?php selected($filter, 2); ?>>Tidak Aktif</option>
													</select>
												</div>
												<div class="col-sm-6">
													<div class="box-tools">
														<div class="input-group input-group-sm pull-right">
															<input name="cari" id="cari" class="form-control" placeholder="Cari..." type="text" value="<?=html_escape($cari)?>" onkeypress="if (event.keyCode == 13):$('#'+'mainform').attr('action', '<?=site_url('web/search/$cat')?>');$('#'+'mainform').submit();endif">
															<div class="input-group-btn">
																<button type="submit" class="btn btn-default" onclick="$('#'+'mainform').attr('action', '<?=site_url("web/search/$cat")?>');$('#'+'mainform').submit();"><i class="fa fa-search"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-sm-12">
													<div class="table-responsive">
														<table class="table table-bordered table-striped dataTable table-hover">
															<thead class="bg-gray disabled color-palette">
																<tr>
																	<th><input type="checkbox" id="checkall"/></th>
																	<th>No</th>
																	<th>Aksi</th>
																	<?php if ($o==2): ?>
                                    <th><a href="<?= site_url("web/index/$cat/$p/1")?>">Judul <i class='fa fa-sort-asc fa-sm'></i></a></th>
                                  <?php elseif ($o==1): ?>
                                    <th><a href="<?= site_url("web/index/$cat/$p/2")?>">Judul <i class='fa fa-sort-desc fa-sm'></i></a></th>
                                  <?php else: ?>
                                    <th><a href="<?= site_url("web/index/$cat/$p/1")?>">Judul <i class='fa fa-sort fa-sm'></i></a></th>
                                  <?php endif; ?>
                                  <?php if ($o==4): ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/3")?>">Aktif <i class='fa fa-sort-asc fa-sm'></i></a></th>
                                  <?php elseif ($o==3): ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/4")?>">Aktif <i class='fa fa-sort-desc fa-sm'></i></a></th>
                                  <?php else: ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/3")?>">Aktif <i class='fa fa-sort fa-sm'></i></a></th>
                                  <?php endif; ?>
																	<?php if ($o==6): ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/5")?>">Diposting Pada <i class='fa fa-sort-asc fa-sm'></i></a></th>
                                  <?php elseif ($o==5): ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/6")?>">Diposting Pada <i class='fa fa-sort-desc fa-sm'></i></a></th>
                                  <?php else: ?>
                                    <th nowrap><a href="<?= site_url("web/index/$cat/$p/5")?>">Diposting Pada <i class='fa fa-sort fa-sm'></i></a></th>
                                  <?php endif; ?>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($main as $data): ?>
																	<tr>
																		<td><input type="checkbox" name="id_cb[]" value="<?=$data['id']?>" <?php $data['boleh_ubah'] or print('disabled')?> /></td>
																		<td><?=$data['no']?></td>
																		<td nowrap>
																			<?php if ($data['boleh_ubah']): ?>
																				<a href="<?=site_url("web/form/$cat/$p/$o/$data[id]")?>" class="btn bg-orange btn-flat btn-sm" title="Ubah Data"><i class="fa fa-edit"></i></a>
																				<a href="<?=site_url("web/ubah_kategori_form/$data[id]")?>" class="btn bg-purple btn-flat btn-sm" data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Ubah Kategori" title="Ubah Kategori"><i class="fa fa-folder-open"></i></a>
																				<?php if ($data['boleh_komentar']): ?>
																					<a href="<?=site_url("web/komentar_lock/$cat/$data[id]")?>" class="btn bg-info btn-flat btn-sm" title="Tutup komentar artikel"><i class="fa fa-comment-o"></i></a>
																				<?php else: ?>
																					<a href="<?=site_url("web/komentar_unlock/$cat/$data[id]")?>" class="btn bg-info btn-flat btn-sm" title="Buka komentar artikel"><i class="fa fa-comment"></i></a>
																				<?php endif; ?>
																				<?php if ($this->CI->cek_hak_akses('h')): ?>
																					<a href="#" data-href="<?=site_url("web/delete/$cat/$p/$o/$data[id]")?>" class="btn bg-maroon btn-flat btn-sm"  title="Hapus" data-toggle="modal" data-target="#confirm-delete"><i class="fa fa-trash-o"></i></a>
																				<?php endif; ?>
																				<?php if ($data['enabled'] == '2'): ?>
																					<a href="<?=site_url("web/artikel_lock/$cat/$data[id]")?>" class="btn bg-navy btn-flat btn-sm" title="Aktifkan Artikel"><i class="fa fa-lock">&nbsp;</i></a>
																				<?php elseif ($data['enabled'] == '1'): ?>
																					<a href="<?=site_url("web/artikel_unlock/$cat/$data[id]")?>" class="btn bg-navy btn-flat btn-sm" title="Non Aktifkan Artikel"><i class="fa fa-unlock"></i></a>
																					<a href="<?=site_url("web/headline/$cat/$p/$o/$data[id]")?>" class="btn bg-teal btn-flat btn-sm" title="Jadikan Headline">
																						<i class="<?= ($data['headline']==1) ? 'fa fa-star-o' : 'fa fa-star' ?>"></i>
																					</a>
																					<a href="<?=site_url("web/slide/$cat/$p/$o/$data[id]")?>" class="btn bg-gray btn-flat btn-sm" title="<?= ($data['headline']==3) ? 'Keluarkan dari slide' : 'Masukkan ke dalam slide' ?>">
																						<i class="<?= ($data['headline']==3) ? 'fa fa-pause' : 'fa fa-play' ?>"></i>
																					</a>
																				<?php endif; ?>
																			<?php endif; ?>
																			<a href="<?= site_url('first/artikel/'.$data['thn'].'/'.$data['bln'].'/'.$data['hri'].'/'.$data['slug']) ?>" target="_blank" class="btn bg-green btn-flat btn-sm" title="Lihat Artikel">
																				<i class="fa fa-eye"></i>
																			</a>
                                    </td>
                                    <td width="50%"><?= $data['judul']?></td>
																		<td><?= $data['aktif']?></td>
																		<td nowrap><?= tgl_indo2($data['tgl_upload'])?></td>
																	</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</form>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="dataTables_length">
                          <form id="paging" action="<?= site_url("web/pager/$cat")?>" method="post" class="form-horizontal">
                            <label>
                              Tampilkan
                              <select name="per_page" class="form-control input-sm" onchange="$('#paging').submit()">
                                <option value="20" <?php selected($per_page, 20); ?> >20</option>
                                <option value="50" <?php selected($per_page, 50); ?> >50</option>
                                <option value="100" <?php selected($per_page, 100); ?> >100</option>
                              </select>
                              Dari
                              <strong><?= $paging->num_rows?></strong>
                              Total Data
                            </label>
                          </form>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers">
                          <ul class="pagination">
                            <?php if ($paging->start_link): ?>
                              <li><a href="<?=site_url("web/index/$cat/$paging->start_link/$o")?>" aria-label="First"><span aria-hidden="true">Awal</span></a></li>
                            <?php endif; ?>
                            <?php if ($paging->prev): ?>
                              <li><a href="<?=site_url("web/index/$cat/$paging->prev/$o")?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                            <?php endif; ?>
                            <?php for ($i=$paging->start_link;$i<=$paging->end_link;$i++): ?>
                              <li <?=jecho($p, $i, "class='active'")?>><a href="<?= site_url("web/index/$cat/$i/$o")?>"><?= $i?></a></li>
                            <?php endfor; ?>
                            <?php if ($paging->next): ?>
                              <li><a href="<?=site_url("web/index/$cat/$paging->next/$o")?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
                            <?php endif; ?>
                            <?php if ($paging->end_link): ?>
                              <li><a href="<?=site_url("web/index/$cat/$paging->end_link/$o")?>" aria-label="Last"><span aria-hidden="true">Akhir</span></a></li>
                            <?php endif; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
									</div>
								</div>
							</div>
							<div class='modal fade' id='confirm-delete' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content'>
										<div class='modal-header'>
											<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
											<h4 class='modal-title' id='myModalLabel'><i class='fa fa-exclamation-triangle text-red'></i> Konfirmasi</h4>
										</div>
										<div class='modal-body btn-info'>
											Apakah Anda yakin ingin menghapus data ini?
										</div>
										<div class='modal-footer'>
											<button type="button" class="btn btn-social btn-flat btn-warning btn-sm" data-dismiss="modal"><i class='fa fa-sign-out'></i> Tutup</button>
											<a class='btn-ok'>
												<button type="button" class="btn btn-social btn-flat btn-danger btn-sm" id="ok-delete"><i class='fa fa-trash-o'></i> Hapus</button>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>

