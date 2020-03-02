<form method="post" action="/auth" class="form-horizontal">
  <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
  <div class="form-group m-t-20">
    <div class="col-xs-12 col-md-4">
      <label>Personal nuber</label>
      <input name="personal_number" class="form-control" type="text" placeholder="Personal number (12 digits)">
      <span class="help-block"></span>
    </div>
  </div>
  <?php if (isset($data)) echo $data ?>
</form>