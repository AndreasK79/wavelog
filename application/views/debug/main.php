<div class="container debug_main">

<h2><?php echo $page_title; ?></h2>

<div class="row">
    <div class="col">

        <div class="card">
            <div class="card-header">Wavelog Information</div>
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td>Version</td>
                        <td><?php echo $this->optionslib->get_option('version')."\n"; ?></td>
                    </tr>
                    <tr>
                        <td>Language</td>
                        <td><?php echo ucfirst($this->config->item('language'))."\n"; ?></td>
                    </tr>
                    <tr>
                        <td>Base URL</td>
                        <td><span id="baseUrl"><a href="<?php echo $this->config->item('base_url')?>" target="_blank"><?php echo $this->config->item('base_url'); ?></a></span> <span data-bs-toggle="tooltip" title="<?php echo lang('copy_to_clipboard'); ?>" onclick='copyURL("<?php echo $this->config->item('base_url'); ?>")'><i class="copy-icon fas fa-copy"></span></td>
                    </tr>
                    <tr>
                        <td>Migration</td>
                        <td><?php echo (isset($migration_version) ? $migration_version : "<span class='badge text-bg-danger'>There is something wrong with your Migration in Database!</span>"); ?></td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Server Information</div>
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td>Server Software</td>
                        <td><?php echo $_SERVER['SERVER_SOFTWARE']; ?></td>
                    </tr>

                    <tr>
                        <td>PHP Version</td>
                        <td><?php echo phpversion(); ?></td>
                    </tr>

                    <tr>
                        <td>MySQL Version</td>
                        <td><?php echo $this->db->version(); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Codeigniter</div>
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td>Version</td>
                        <td><?php echo CI_VERSION; ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Folder Permissions</div>
            <div class="card-body">
                <p>This checks the folders Wavelog uses are read and writeable by PHP.</p>
                <table width="100%">
                    <tr>
                        <td>/backup</td>
                        <td>
                            <?php if($backup_folder == true) { ?>
                                <span class="badge text-bg-success">Success</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Failed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>/updates</td>
                        <td>
                            <?php if($updates_folder == true) { ?>
                                <span class="badge text-bg-success">Success</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Failed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>/uploads</td>
                        <td>
                            <?php if($uploads_folder == true) { ?>
                                <span class="badge text-bg-success">Success</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Failed</span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-header">PHP Modules</div>
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td>curl</td>
                        <td>
                            <?php if(in_array  ('curl', get_loaded_extensions())) { ?>
                                <span class="badge text-bg-success">Installed</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Not Installed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>MySQL</td>
                        <td>
                            <?php if(in_array  ('mysqli', get_loaded_extensions())) { ?>
                                <span class="badge text-bg-success">Installed</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Not Installed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>mbstring</td>
                        <td>
                            <?php if(in_array  ('mbstring', get_loaded_extensions())) { ?>
                                <span class="badge text-bg-success">Installed</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Not Installed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>xml</td>
                        <td>
                            <?php if(in_array  ('xml', get_loaded_extensions())) { ?>
                                <span class="badge text-bg-success">Installed</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Not Installed</span>
                            <?php } ?>
                        </td>
                    </tr>

                    <tr>
                        <td>zip</td>
                        <td>
                            <?php if(in_array  ('zip', get_loaded_extensions())) { ?>
                                <span class="badge text-bg-success">Installed</span>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">Not Installed</span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php if (file_exists('.git')) { ?>
        <?php
			//Below is a failsafe where git commands fail
			try {
				$commitHash = trim(exec('git log --pretty="%H" -n1 HEAD'));
				$branch = '';
				$remote = '';
				$owner = '';
				// only proceed here if git can actually be executed
				if ($commitHash != "") {
					$commitDate = trim(exec('git log --pretty="%ci" -n1 HEAD'));
					$line = trim(exec('git log -n 1 --pretty=%D HEAD'));
					$pieces = explode(', ', $line);
					$lastFetch = trim(exec('stat -c %Y .git/FETCH_HEAD'));
					//Below is a failsafe for systems without the stat command
					try {
						$dt = new DateTime("@$lastFetch");
					} catch(Exception $e) {
						$dt = new DateTime(date("Y-m-d H:i:s"));
					}
					if (isset($pieces[1])) {
						$remote = substr($pieces[1], 0, strpos($pieces[1], '/'));
						$branch = substr($pieces[1], strpos($pieces[1], '/')+1);
						$url = trim(exec('git remote get-url '.$remote));
						if (strpos($url, 'https://github.com') !== false) {
							$owner = preg_replace('/https:\/\/github\.com\/(\w+)\/Wavelog\.git/', '$1', $url);
						} else if (strpos($url, 'git@github.com') !== false) {
							$owner = preg_replace('/git@github\.com:(\w+)\/Wavelog\.git/', '$1', $url);
						}
					}
					$tag = trim(exec('git describe --tags '.$commitHash));
				}
			} catch (\Throwable $th) {
				$commitHash = "";
			}
        ?>

        <?php if($commitHash != "") { ?>
        <div class="card">
            <div class="card-header">Git Information</div>
            <div class="card-body">
                <table width="100%">
                    <tr>
                        <td>Branch</td>
                        <td>
                            <?php if($branch != "") { ?>
                                <?php if($owner != "") { ?>
                                    <a target="_blank" href="https://github.com/<?php echo $owner; ?>/Wavelog/tree/<?php echo $branch?>">
                                <?php } ?>
                                    <span class="badge text-bg-success"><?php echo $branch; ?></span>
                                <?php if($owner != "") { ?>
                                    </a>
                                <?php } ?>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">n/a</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Commit</td>
                        <td>
                            <?php if($commitHash != "") { ?>
                                <a target="_blank" href="https://github.com/wavelog/wavelog/commit/<?php echo $commitHash?>"><span class="badge text-bg-success"><?php echo substr($commitHash,0,8); ?></span></a>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">n/a</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tag</td>
                        <td>
                            <?php if($commitHash != "") { ?>
                                <a target="_blank" href="https://github.com/wavelog/wavelog/releases/tag/<?php echo substr($tag,0,strpos($tag, '-')); ?>"><span class="badge text-bg-success"><?php echo $tag; ?></span></a>
                            <?php } else { ?>
                                <span class="badge text-bg-danger">n/a</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Last Fetch</td>
                        <td>
							<?php echo ($dt == null ? '' : $dt->format(\DateTime::RFC850)); ?>
                        </td>
                    </tr>
                </table>
                </table>
            </div>
        </div>
        <?php }


			// Get Date format
		if($this->session->userdata('user_date_format')) {
			// If Logged in and session exists
			$custom_date_format = $this->session->userdata('user_date_format');
		} else {
			// Get Default date format from /config/wavelog.php
			$custom_date_format = $this->config->item('qso_date_format');
		}
		?>
		<div class="card">
            <div class="card-header">File download date</div>
            <div class="card-body">
                <table width="100%" class = "table-sm table table-hover table-striped">
					<thead>
						<th>File</th>
						<th>Last update</th>
						<th></th>
					</thead>
					<tr>
						<td>DXCC update from Club Log</td>
						<td><?php echo (($this->optionslib->get_option('dxcc_clublog_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('dxcc_clublog_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('dxcc_clublog_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update');?>">Update</a></td>

                    </tr>
					<tr>
						<td>DOK file download</td>
						<td><?php echo (($this->optionslib->get_option('dok_file_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('dok_file_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('dok_file_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/update_dok');?>">Update</a></td>
                    </tr>
					<tr>
						<td>LoTW users download</td>
						<td><?php echo (($this->optionslib->get_option('lotw_users_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('lotw_users_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('lotw_users_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/lotw_users');?>">Update</a></td>
					</tr>
					<tr>
                        <td>POTA file download</td>
						<td><?php echo (($this->optionslib->get_option('pota_file_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('pota_file_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('pota_file_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/update_pota');?>">Update</a></td>
                    </tr>
					<tr>
						<td>SCP file download</td>
						<td><?php echo (($this->optionslib->get_option('scp_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('scp_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('scp_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/update_clublog_scp');?>">Update</a></td>
                    </tr>
					<tr>
						<td>SOTA file download</td>
						<td><?php echo (($this->optionslib->get_option('sota_file_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('sota_file_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('sota_file_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/update_sota');?>">Update</a></td>
					</tr>
					<tr>
                        <td>WWFF file downlaod</td>
						<td><?php echo (($this->optionslib->get_option('wwff_file_update') ?? '') == '' ? '' : date($custom_date_format, strtotime($this->optionslib->get_option('wwff_file_update') ?? ''))  . ' ' . date("h:i", strtotime($this->optionslib->get_option('wwff_file_update') ?? '')))  ?></td>
						<td><a class="btn btn-sm btn-primary" href="<?php echo site_url('update/update_wwff');?>">Update</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

</div>
