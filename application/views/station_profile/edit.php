<div class="container" id="create_station_profile">

<br>
	<?php if($this->session->flashdata('message')) { ?>
		<!-- Display Message -->
		<div class="alert-message error">
		  <p><?php echo $this->session->flashdata('message'); ?></p>
		</div>
	<?php } ?>

	<?php if($this->session->flashdata('notice')) { ?>
		<div id="message" >
			<?php echo $this->session->flashdata('notice'); ?>
		</div>
	<?php } ?>

	<?php $this->load->helper('form'); ?>

	<?php echo validation_errors(); ?>

	<?php if($my_station_profile->station_id != NULL) {
		$form_action = __("Update");
	?>
		<form method="post" action="<?php echo site_url('station/edit/'); ?><?php echo $my_station_profile->station_id; ?>" name="create_profile">
			<input type="hidden" name="station_id" value="<?php echo $my_station_profile->station_id; ?>">

	<?php } else {
		$form_action = __("Create");
	?>
		<form method="post" action="<?php echo site_url('station/copy/'); ?><?php echo $copy_from; ?>" name="create_profile">
	<?php } ?>

	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-header"><?php echo $page_title; ?> <?php echo "(" . __("Callsign") . ": "; ?> <?php echo $my_station_profile->station_callsign; ?>)</div>
				<div class="card-body">

					<div class="mb-3">
						<label for="stationNameInput"><?php echo __("Location Name"); ?></label>
						<input type="text" class="form-control" name="station_profile_name" id="stationNameInput" aria-describedby="stationNameInputHelp" value="<?php if(set_value('station_profile_name') != "") { echo set_value('station_profile_name'); } else { echo $my_station_profile->station_profile_name; } ?>" required>
						<small id="stationNameInputHelp" class="form-text text-muted"><?php echo sprintf(__("Shortname for the station location. For example: %s"), _pgettext("Station Location Setup", "Home QTH")); ?></small>
					</div>

					<div class="mb-3">
						<label for="stationCallsignInput"><?php echo __("Station Callsign"); ?></label>
						<input type="text" class="form-control" name="station_callsign" id="stationCallsignInput" aria-describedby="stationCallsignInputHelp" value="<?php if(set_value('station_callsign') != "") { echo set_value('station_callsign'); } else { echo $my_station_profile->station_callsign; } ?>" required>
						<small id="stationCallsignInputHelp" class="form-text text-muted"><?php echo __("Station callsign. For example: 4W7EST/P"); ?></small>
					</div>

					<div class="mb-3">
						<label for="stationPowerInput"><?php echo __("Station Power (W)"); ?></label>
						<input type="number" class="form-control" name="station_power" step="1" id="stationPowerInput" aria-describedby="stationPowerInputHelp" value="<?php if(set_value('station_power') != "") { echo set_value('station_power'); } else { echo $my_station_profile->station_power; } ?>">
						<small id="stationPowerInputHelp" class="form-text text-muted"><?php echo __("Default station power in Watt. Overwritten by CAT."); ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<!-- Location Ends -->
		<div class="col-md">
			<div class="card">
				<div class="card-header"><?php echo __("Location"); ?></div>
				<div class="card-body">
					<!-- DXCC -->
					<div class="mb-3">
					    <label for="stationDXCCInput"><?php echo __("Station DXCC"); ?></label>
					    <?php if ($dxcc_list->num_rows() > 0) { ?>
					        <select class="form-select" id="dxcc_id" name="dxcc" aria-describedby="stationCallsignInputHelp">
					            <option value="0" <?php if($my_station_profile->station_dxcc == "0") { ?>selected<?php } ?>><?php echo "- " . _pgettext("DXCC selection", "None") . " -"; ?></option>
					            <?php foreach ($dxcc_list->result() as $dxcc) { ?>
					                <?php $isDeleted = $dxcc->end !== NULL; ?>
					                <option value="<?php echo $dxcc->adif; ?>" <?php if($my_station_profile->station_dxcc == $dxcc->adif) { ?>selected<?php } ?>>
					                    <?php echo ucwords(strtolower($dxcc->name)) . ' - ' . $dxcc->prefix;
					                    if ($isDeleted) {
					                        echo ' (' . __("Deleted DXCC") . ')';
					                    }
					                    ?>
					                </option>
					            <?php } ?>
					        </select>
					        <?php } ?>
					    <small id="stationDXCCInputHelp" class="form-text text-muted"><?php echo __("Station DXCC entity. For example: Bolivia"); ?></small>
						<div class="alert alert-danger" role="alert" id="warningMessageDXCC" style="display: none"> </div>
					</div>

					<!-- City -->
					<div class="mb-3">
						<label for="stationCityInput"><?php echo __("Station City"); ?></label>
						<input type="text" class="form-control" name="city" id="stationCityInput" aria-describedby="stationCityInputHelp" value="<?php if(set_value('city') != "") { echo set_value('city'); } else { echo $my_station_profile->station_city; } ?>">
		    			<small id="stationCityInputHelp" class="form-text text-muted"><?php echo __("Station city. For example: Oslo"); ?></small>
		  			</div>

					<!-- State -->
					<script>
						var set_state = '<?php echo $my_station_profile->state; ?>';
					</script>
					<div class="mb-3" id="location_state">
		    			<label for="stateInput" id="stateInputLabel"></label>
						<select class="form-select" name="station_state" id="stateDropdown">
							<option value=""></option>
						</select>
						<small id="StateHelp" class="form-text text-muted"><?php echo __("Station state. Applies to certain countries only."); ?></small>
					</div>

					<!-- US County -->
					<div class="mb-3" id="location_us_county">
						<label for="stationCntyInput"><?php echo __("Station County"); ?></label>
						<input type="text" class="form-control" name="station_cnty" id="stationCntyInputEdit" aria-describedby="stationCntyInputHelp" value="<?php if(set_value('station_cnty') != "") { echo set_value('station_cnty'); } else { echo $my_station_profile->station_cnty; } ?>">
						<small id="stationCntyInputHelp" class="form-text text-muted"><?php echo __("Station County (Only used for USA/Alaska/Hawaii)."); ?></small>
					</div>
				</div>
			</div>
		</div>
		<!-- Location Ends -->

		<!-- Zones -->
		<div class="col-md">
			<div class="card">
				<div class="card-header"><?php echo __("Zones"); ?></div>
				<div class="card-body">
					<!-- CQ Zone -->
					<div class="mb-3">
						<label for="stationCQZoneInput"><?php echo __("CQ Zone"); ?></label>
						<select class="form-select" id="stationCQZoneInput" name="station_cq" required>
							<?php
							for ($i = 1; $i<=40; $i++) {
								echo '<option value='. $i;
								if ($my_station_profile->station_cq == $i) {
									echo " selected=\"selected\"";
								}
								echo '>'. $i .'</option>';
							}
							?>
						</select>
						<small id="stationCQInputHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("uses 'click here'","If you don't know your CQ Zone then %s to find it!"),"<a href='https://zone-check.eu/?m=cq' target='_blank'>".__("click here")."</a> "); ?></small>
					</div>

					<!-- ITU Zone -->
					<div class="mb-3">
                    	<label for="stationITUZoneInput"><?php echo __("ITU Zone"); ?></label>
                    	<select class="form-select" id="stationITUZoneInput" name="station_itu" required>
							<?php
							for ($i = 1; $i<=90; $i++) {
								echo '<option value='. $i;
								if ($my_station_profile->station_itu == $i) {
									echo " selected=\"selected\"";
								}
								echo '>'. $i .'</option>';
							}
							?>
                    	</select>
                    	<small id="stationITUInputHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("uses 'click here'","If you don't know your ITU Zone then %s to find it!"),"<a href='https://zone-check.eu/?m=itu' target='_blank'>".__("click here")."</a> "); ?></small>
                	</div>

				</div>
			</div>
		</div>
		<!-- Zones End -->
	</div>

	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("Station Gridsquare"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
		    			<label for="stationGridsquareInput"><?php echo __("Station Gridsquare"); ?></label>

						<div class="input-group mb-3">
						<input type="text" class="form-control" name="gridsquare" id="stationGridsquareInput" aria-describedby="stationGridInputHelp" value="<?php if(set_value('gridsquare') != "") { echo set_value('gridsquare'); } else { echo $my_station_profile->station_gridsquare; } ?>" required>
							<div class="input-group-append">
								<button type="button" class="btn btn-outline-secondary" onclick="getLocation()"><i class="fas fa-compass"></i> <?php echo __("Get Gridsquare"); ?></button>
							</div>
						</div>

		    <small id="stationGridInputHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("uses 'click here'", "Station gridsquare. For example: HM54AP. If you don't know your grid square then %s!"), "<a href='https://zone-check.eu/?m=loc' target='_blank'>".__("click here")."</a>"); ?></small><br>
		    			<small id="stationGridInputHelp" class="form-text text-muted"><?php echo __("If you are located on a grid line, enter multiple grid squares separated with commas. For example: IO77,IO78,IO87,IO88."); ?></small>
		  			</div>
				</div>
			</div>
		</div>

		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("IOTA"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
                		<label for="stationIOTAInput"><?php echo __("IOTA Reference"); ?></label>
                		<select class="form-select" name="iota" id="stationIOTAInput" aria-describedby="stationIOTAInputHelp" placeholder="EU-005">
                    		<option value =""></option>
                    		<?php
                    			foreach($iota_list as $i){
                        		echo '<option value=' . $i->tag;
		                        if ($my_station_profile->station_iota == $i->tag) {
        		                    echo " selected =\"selected\"";
                		        }
                        		echo '>' . $i->tag . ' - ' . $i->name . '</option>';
                    			}
                    		?>
                		</select>

						<small id="stationIOTAInputHelp" class="form-text text-muted"><?php echo __("Station IOTA reference. For example: EU-005"); ?></small>
                		<small id="stationIOTAInputHelp" class="form-text text-muted"><?php echo sprintf(__("You can look up IOTA references at the %s."), "<a target='_blank' href='https://www.iota-world.org/iota-directory/annex-f-short-title-iota-reference-number-list.html'>".__("IOTA World website")."</a>"); ?></small>
            		</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("SOTA"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
		    			<label for="stationSOTAInput"><?php echo __("SOTA Reference"); ?></label>
		    			<input type="text" class="form-control" name="sota" id="stationSOTAInput" aria-describedby="stationSOTAInputHelp" value="<?php if(set_value('sota') != "") { echo set_value('sota'); } else { echo $my_station_profile->station_sota; } ?>">
		    			<small id="stationSOTAInputHelp" class="form-text text-muted"><?php echo sprintf(__("Station SOTA reference. You can look up SOTA references at the %s."), "<a target='_blank' href='https://www.sotamaps.org/'>".__("SOTA Maps website")."</a>"); ?></small>
		  			</div>
				</div>
			</div>
		</div>

		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("WWFF"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
						<label for="stationWWFFInput"><?php echo __("WWFF Reference"); ?></label>
						<input type="text" class="form-control" name="wwff" id="stationWWFFInput" aria-describedby="stationWWFFInputHelp" value="<?php if(set_value('wwff') != "") { echo set_value('wwff'); } else { echo $my_station_profile->station_wwff; } ?>">
						<small id="stationWWFFInputHelp" class="form-text text-muted"><?php echo sprintf(__("Station WWFF reference. You can look up WWFF references at the %s."), "<a target='_blank' href='https://www.cqgma.org/mvs/'>".__("GMA Map website")."</a>"); ?></small>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("POTA"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
						<label for="stationPOTAInput"><?php echo __("POTA Reference(s)"); ?></label>
						<input type="text" class="form-control" name="pota" id="stationPOTAInput" aria-describedby="stationPOTAInputHelp" value="<?php if(set_value('pota') != "") { echo set_value('pota'); } else { echo $my_station_profile->station_pota; } ?>">
						<small id="stationPOTAInputHelp" class="form-text text-muted"><?php echo sprintf(__("Station POTA reference(s). Multiple comma separated values allowed. You can look up POTA references at the %s."), "<a target='_blank' href='https://pota.app/#/map/'>".__("POTA Map website")."</a>"); ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("Signature"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
		    			<label for="stationSigInput"><?php echo __("Signature Name"); ?></label>
		    			<input type="text" class="form-control" name="sig" id="stationSigInput" aria-describedby="stationSigInputHelp" value="<?php if(set_value('sig') != "") { echo set_value('sig'); } else { echo $my_station_profile->station_sig; } ?>">
		    			<small id="stationSigInputHelp" class="form-text text-muted"><?php echo __("Station Signature (e.g. GMA).."); ?></small>
					</div>

					<div class="mb-3">
		    			<label for="stationSigInfoInput"><?php echo __("Signature Information"); ?></label>
		    			<input type="text" class="form-control" name="sig_info" id="stationSigInfoInput" aria-describedby="stationSigInfoInputHelp" value="<?php if(set_value('sig_info') != "") { echo set_value('sig_info'); } else { echo $my_station_profile->station_sig_info; } ?>">
		    			<small id="stationSigInfoInputHelp" class="form-text text-muted"><?php echo __("Station Signature Info (e.g. DA/NW-357)."); ?></small>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header"><?php echo __("eQSL"); ?></h5>
				<div class="card-body">
					<div class="mb-3">
		    			<label for="eqslNickname"><?php echo _pgettext("Probably no translation needed","eQSL QTH Nickname"); ?></label> <!-- This does not need Multilanguage Support -->
		    			<input type="text" class="form-control" name="eqslnickname" id="eqslNickname" aria-describedby="eqslhelp" value="<?php if(set_value('eqslnickname') != "") { echo set_value('eqslnickname'); } else { echo $my_station_profile->eqslqthnickname; } ?>">
		    			<small id="eqslhelp" class="form-text text-muted"><?php echo __("The QTH Nickname which is configured in your eQSL Profile"); ?></small>
		  			</div>
					<div class="mb-3">
		    			<label for="eqslDefaultQSLMsg"><?php echo __("Default QSLMSG"); ?></label>
						<label class="position-absolute end-0 mb-2 me-3" for="eqslDefaultQSLMsg" id="charsLeft"> </label>
		    			<textarea class="form-control" name="eqsl_default_qslmsg" id="eqslDefaultQSLMsg" aria-describedby="eqsldefaultqslmsghelp" maxlength="240" rows="2" style="width:100%;" value="<?php echo $my_station_profile->eqsl_default_qslmsg; ?>"><?php echo $my_station_profile->eqsl_default_qslmsg; ?></textarea>
		    			<small id="eqsldefaultqslmsghelp" class="form-text text-muted"><?php echo __("Define a default message that will be populated and sent for each QSO for this station location."); ?></small>
		  			</div>
				</div>
			</div>
		</div>

		<div class="col-md">
			<div class="card">
				<h5 class="card-header">QRZ.com <span class="badge text-bg-warning"> <?php echo __("Subscription Required"); ?></span></h5> <!-- "QRZ.com" does not need Multilanguage Support -->
				<div class="card-body">
					<div class="mb-3">
						<label for="qrzApiKey">QRZ.com Logbook API Key</label> <!-- This does not need Multilanguage Support -->
						<div class="input-group">
							<input type="text" class="form-control" name="qrzapikey" pattern="^([A-F0-9]{4}-){3}[A-F0-9]{4}$" id="qrzApiKey" aria-describedby="qrzApiKeyHelp" value="<?php if(set_value('qrzapikey') != "") { echo set_value('qrzapikey'); } else { echo $my_station_profile->qrzapikey; } ?>">
							<button class="btn btn-secondary" type="button" id="qrz_apitest_btn">Test API-Key</button>
						</div>
						<div class="alert mt-3" style="display: none;" id="qrz_apitest_msg"></div>
						<small id="qrzApiKeyHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("the QRZ.com Logbook settings page", "Find your API key on %s"), "<a href='https://logbook.qrz.com/logbook' target='_blank'>".__("the QRZ.com Logbook settings page")."</a>"); ?></a></small>
					</div>

					<div class="mb-3">
						<label for="qrzrealtime"><?php echo __("QRZ.com Logbook Upload"); ?></label>
						<select class="form-select" id="qrzrealtime" name="qrzrealtime">
							<option value="-1" <?php if ($my_station_profile->qrzrealtime == -1) { echo " selected =\"selected\""; } ?>><?php echo __("Disabled"); ?></option>
							<option value="1" <?php if ($my_station_profile->qrzrealtime == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Realtime"); ?></option>
							<option value="0" <?php if ($my_station_profile->qrzrealtime == 0) { echo " selected =\"selected\""; } ?>><?php echo __("Enabled"); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header">ClubLog</h5> <!-- This does not need Multilanguage Support -->
				<div class="card-body">
					<div class="mb-3">
						<label for="clublogignore"><?php echo __("Ignore Clublog Upload"); ?></label>
						<select class="form-select" id="clublogignore" name="clublogignore">
							<option value="1" <?php if ($my_station_profile->clublogignore == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->clublogignore == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
						<small class="form-text text-muted"><?php echo __("If enabled, the QSOs made from this location will not be uploaded to Clublog. If this is deactivated on it's own please check if the Call is properly configured at Clublog"); ?></small>
					</div>
					<div class="mb-3" id="clublogrealtimediv">
						<label for="clublogrealtime"><?php echo __("ClubLog Realtime Upload"); ?></label>
						<select class="form-select" id="clublogrealtime" name="clublogrealtime">
							<option value="1" <?php if ($my_station_profile->clublogrealtime == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->clublogrealtime == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header">HRDLog.net</h5> <!-- This does not need Multilanguage Support -->
				<div class="card-body">
					<div class="mb-3">
						<label for="webadifApiKey"><?php echo __("HRDLog.net Username"); ?></label>
						<input type="text" class="form-control" name="hrdlog_username" id="hrdlog_username" aria-describedby="hrdlog_usernameHelp" value="<?php if(set_value('hrdlog_username') != "") { echo set_value('hrdlog_username'); } else { echo $my_station_profile->hrdlog_username; } ?>">
						<small id="hrdlog_usernameHelp" class="form-text text-muted"><?php echo __("The username you are registered with at HRDlog.net (usually your callsign)."); ?></a></small>
					</div>
					<div class="mb-3">
						<label for="webadifApiKey"><?php echo __("HRDLog.net API Key"); ?></label>
						<input type="text" class="form-control" name="hrdlog_code" id="hrdlog_code" aria-describedby="hrdlog_codeHelp" value="<?php if(set_value('hrdlog_code') != "") { echo set_value('hrdlog_code'); } else { echo $my_station_profile->hrdlog_code; } ?>">
						<small id="hrdlog_codeHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("HRDLog.net Userprofile page", "Create your API Code on your %s"), "<a href='http://www.hrdlog.net/EditUser.aspx' target='_blank'>".__("HRDLog.net Userprofile page")."</a>"); ?></a></small>
					</div>
					<div class="mb-3">
						<label for="hrdlogrealtime"><?php echo __("HRDLog.net Logbook Realtime Upload"); ?></label>
						<select class="form-select" id="hrdlogrealtime" name="hrdlogrealtime">
							<option value="1" <?php if ($my_station_profile->hrdlogrealtime == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->hrdlogrealtime == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header">QO-100 Dx Club</h5> <!-- This does not need Multilanguage Support -->
				<div class="card-body">
					<div class="mb-3">
						<label for="webadifApiKey"><?php echo _pgettext("Probably no translation needed","QO-100 Dx Club API Key"); ?></label>
						<input type="text" class="form-control" name="webadifapikey" id="webadifApiKey" aria-describedby="webadifApiKeyHelp" value="<?php if(set_value('webadifapikey') != "") { echo set_value('webadifapikey'); } else { echo $my_station_profile->webadifapikey; } ?>">
						<small id="webadifApiKeyHelp" class="form-text text-muted"><?php echo sprintf(_pgettext("QO-100 Dx Club's profile page", "Create your API key on your %s"), "<a href='https://qo100dx.club' target='_blank'>".__("QO-100 Dx Club's profile page")."</a>"); ?></a></small>
					</div>
					<div class="mb-3">
						<label for="webadifrealtime"><?php echo __("QO-100 Dx Club Realtime Upload"); ?></label>
						<select class="form-select" id="webadifrealtime" name="webadifrealtime">
							<option value="1" <?php if ($my_station_profile->webadifrealtime == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->webadifrealtime == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md">
			<div class="card">
				<h5 class="card-header">OQRS</h5> <!-- This does not need Multilanguage Support -->
				<div class="card-body">
					<div class="mb-3">
						<label for="oqrs"><?php echo __("OQRS Enabled"); ?></label>
						<select class="form-select" id="oqrs" name="oqrs">
							<option value="1" <?php if ($my_station_profile->oqrs == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->oqrs == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
					</div>
					<div class="mb-3">
						<label for="oqrs"><?php echo __("OQRS Email alert"); ?></label>
						<select class="form-select" id="oqrsemail" name="oqrsemail">
							<option value="1" <?php if ($my_station_profile->oqrs_email == 1) { echo " selected =\"selected\""; } ?>><?php echo __("Yes"); ?></option>
							<option value="0" <?php if ($my_station_profile->oqrs_email == 0) { echo " selected =\"selected\""; } ?>><?php echo __("No"); ?></option>
						</select>
						<small id="oqrsemailHelp" class="form-text text-muted"><?php echo __("Make sure email is set up under admin and global options."); ?></small>
					</div>
					<div class="mb-3">
						<label for="oqrstext"><?php echo __("OQRS Text"); ?></label>
						<input type="text" class="form-control" name="oqrstext" id="oqrstext" aria-describedby="oqrstextHelp" value="<?php if(set_value('oqrs_text') != "") { echo set_value('oqrs_text'); } else { echo $my_station_profile->oqrs_text; } ?>">
						<small id="oqrstextHelp" class="form-text text-muted"><?php echo __("Some info you want to add regarding QSL'ing."); ?></small>
					</div>

				</div>
			</div>
		</div>
	</div>

	<button type="submit" class="btn btn-primary" style="margin-bottom: 30px;"><i class="fas fa-plus-square"></i> <?php echo $form_action; ?> <?php echo __("Station Location"); ?></button>

	</form>

</div>
