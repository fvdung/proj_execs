<p>Please open and verify the Bank ID application on mobile or Desktop then press the continue button</p>
<form method="post" action="/auth/getUser" class="form-horizontal">
    <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">
    <input type="hidden" name="order_ref" value="<?= $orderRef ?>">
    <button type="submit" class="btn btn-primary">Continue</button>
</form>