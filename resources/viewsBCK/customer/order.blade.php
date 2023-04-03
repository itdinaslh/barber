<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Data Customer</h4>
    <input type="hidden" id="myUid" value="{{ Auth::user()->id }}" />
</div>
<div class="modal-body">
    <div class="row" style="margin-bottom:20px;">
      <div class="col-xs-12">
          <table class="table" id="tblCust">
              <thead>
                  <tr>
                      <th>Member ID</th>
                      <th>Nama</th>
                      <th>Telp</th>
                      <th>Last Visit</th>
                      <th>Total Visit</th>
                      <th>Action</th>
                  </tr>
              </thead>
          </table>
      </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="pull-right">
                <button id="btnAddCust" type="button" class="btn btn-warning" name="button">New Customer</button>
            </div>
        </div>
    </div>
    <div id="formAddCust" class="row" style="display:none;">
        <div class="col-xs-12">
            <div class="modal-header">
                <h4 class="modal-title">Tambah data customer</h4>
            </div>
            <form id="formAddAndOrder" class="" action="{{ url('/customer/addorder') }}" method="post">
                <div class="modal-body">
                      {{ csrf_field() }}
                      <input type="hidden" name="UserID" value="{{ Auth::user()->id }}" />
                      <div class="form-group">
                          <label for="">Nama</label>
                          <input id="txtNama" type="text" name="Nama" class="form-control" autocomplete="off" required />
                      </div>
                      <div class="form-group">
                          <label for="">No KTP</label>
                          <input type="text" name="IdNum" class="form-control" maxlength="16" autocomplete="off" />
                      </div>
                      <div class="form-group">
                          <label for="Occupation">Tanggal Lahir</label>
                          <div class="input-group">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input id="datemask" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" name="BirthDate" data-mask>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="">Phone</label>
                          <input type="text" name="Phone" class="form-control" maxlength="16" autocomplete="off" />
                      </div>
                      <div class="form-group">
                          <label for="">Pekerjaan</label>
                          <input type="text" name="Occupation" class="form-control" autocomplete="off" />
                      </div>
                      <div class="form-group">
                          <label for="">Kota</label>
                          <input type="text" name="City" class="form-control" autocomplete="off" />
                      </div>
                      <div class="form-group">
                          <label for="">Email</label>
                          <input type="email" name="Email" class="form-control" autocomplete="off" />
                      </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save & Order</button>
                </div>
            </form>
        </div>
    </div>
</div>
