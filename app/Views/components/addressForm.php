<?php if (empty($address)) { ?>
                  <h4 class="text-center">Add Address</h4>
                  <form id="address_formdata">
                    <li>
                      <div class="row m-3 justify-content-center">
                        <div class="col-12 col-lg-6">
                          <span class="form-label d-block">State</span>
                          <div class="custom-select form-label d-flex">
                            <select id="state_id_val" name="state_id">
                              <option value="">Select State</option>
                              <?php for ($i = 0; $i < count($state); $i++) { ?>

                                <option value="<?php echo $state[$i]['state_id'] ?>">
                                  <?php echo $state[$i]['state_title'] ?>
                                </option>
                              <?php } ?>
                            </select>
                            <i class="fas fa-chevron-down"></i>
                          </div>
                        </div>
                        <div class="col-12 col-lg-6">
                          <span class="form-label d-block">District</span>
                          <div class="custom-select form-label">
                            <select id="dist_id_val" name="dist_id">
                              <!-- code -->
                            </select>
                          </div>
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                          <span class="form-label d-block">Land Mark</span>
                          <input name="landmark" id="landmark" type="text" class="form-control" value="" />
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                          <span class="form-label d-block">Town / City</span>
                          <input name="city" id="city" type="text" class="form-control" value="" />
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                          <span class="form-label d-block">Address</span>
                          <textarea name="address" id="address" class="form-control" rows="1"></textarea>
                        </div>
                        <div class="col-12 col-lg-6 mb-2">
                          <span class="form-label d-block">Zip/Postal code</span>
                          <input name="pincode" id="pincode" type="text" class="form-control" value="" />
                        </div>
                        <div class="form-check ms-5 my-2">
                          <input class="form-check-input" type="checkbox" id="default_addr" name="default_addr"
                            style="width: 1.25rem; height: 1.25rem;">
                          <label class="form-check-label" for="default_addr">Set as default address</label>
                        </div>
                        <div class="save_cancel_btn p-1">
                          <a type="submit" class="btn me-2  px-3 rounded-3 save_btn" id="save_address">
                            <i class="fa fa-save me-2"></i>Save
                          </a>
                        </div>
                      </div>
                    </li>

                  </form>
                <?php } ?>