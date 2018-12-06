
        <h3>Add new User</h3>
        <hr/>
        <div class="h-wrapper">
            <form method="POST">
                 <div class="row row-sm-offset">

                         <div class="col-xs-12 col-md-4">
                             <div class="form-group">
                                 <label class="form-control-label" for="form1-9-name">Last name<span class="form-asterisk">*</span></label>
                                 <input type="text" class="form-control" name="lname" required="" data-form-field="Lname" id="form1-9-lname">
                             </div>
                         </div>

                         <div class="col-xs-12 col-md-4">
                             <div class="form-group">
                                 <label class="form-control-label" for="form1-9-email">First name<span class="form-asterisk">*</span></label>
                                 <input type="text" class="form-control" name="fname" required="" data-form-field="Fname" id="form1-9-fname">
                             </div>
                         </div>

                         <div class="col-xs-12 col-md-4">
                             <div class="form-group">
                                 <label class="form-control-label" for="form1-9-phone">Middle name<span class="form-asterisk">*</span></label>
                                 <input type="tel" class="form-control" name="mname" data-form-field="MName" id="form1-9-mname">
                             </div>
                         </div>

                </div>

                <div class="row row-sm-offset">

                        <div class="col-xs-12 col-md-4">
                           <div class="form-group">
                               <label class="form-control-label" for="form1-9-gender">Gender</label>
                               <select name="gender" class="form-control" required id="form1-9-gender">

                                         <option value="1">Male</option>
                                         <option value="1">Female</option>
                               </select>
                           </div>
                      </div>

                      <div class="col-xs-12 col-md-4">
                           <div class="form-group">
                               <label class="form-control-label" for="form1-9-birthdate">Birthdate</label>
                               <input type="date" class="form-control" name="birthdate" required="" data-form-field="Date" id="form1-9-birthdate">
                           </div>
                      </div>

                      <div class="col-xs-12 col-md-4">
                          <div class="form-group">
                              <label class="form-control-label" for="form1-9-phone">Position<span class="form-asterisk">*</span></label>
                              <input type="tel" class="form-control" name="position" data-form-field="MName" id="form1-9-mname">
                          </div>
                      </div>

               </div>
			   
			   <div class="row row-sm-offset">
				   <div class="col-xs-12 col-md-4">
					   <div class="form-group">
						   <label class="form-control-label" for="form1-9-munid">Branch<span class="form-asterisk">*</span></label>
						   <select name="branch" class="form-control select2" required="">
								  <?php
								  $mun = new Place();
								  $category = $mun->getMunicipality();
								  foreach ($category as $res) { ?>
									   <option value="<?= $res['lid']?>"><?= $res['description']?></option>
								  <?php } ?>
							 </select>
					   </div>
				   </div>
                </div>
				
               </br>
				</br>
                <h4 >Login Details</h4>
                <hr/>
				<div class="row row-sm-offset">
					<div class="col-xs-12 col-md-4">
						 <div class="form-group">
							 <label class="form-control-label" for="form1-9-address">Username</label>
							 <input type="text" class="form-control" name="username"  required="" data-form-field="Message" id="form1-9-address"/>
						 </div>
					</div>
				
					<div class="col-xs-12 col-md-4">
						 <div class="form-group">
							 <label class="form-control-label" for="form1-9-address">Password</label>
							 <input type="password" class="form-control" name="password" required="" data-form-field="Message" id="form1-9-address"/>
						 </div>
					</div>
					
					 <div class="col-xs-12 col-md-4">
					   <div class="form-group">
						   <label class="form-control-label" for="form1-9-munid">Role<span class="form-asterisk">*</span></label>
						   <select name="access" class="form-control select2" required="">
									   <option value="1">Administrator</option>
									   <option value="2">Cashier</option>
							 </select>
					   </div>
				   </div>
				</div>
               <br/>
               <hr/>
                <button class="btn btn-success"><i class="fa fa-floppy-o fa-lg"></i>&nbsp;Save</button>
            </form>
        </div>
