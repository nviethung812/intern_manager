<form class="w3-container" action="student_register_success.php" method="POST">
    <div class="w3-section">
        <h4> Do you want to register to this request?</h3>
        <input type="hidden" name="requestId" value="<?= $requestId;?>">
        <input type="hidden" name="studentId" value="<?= $student_id;?>">
        <input class="w3-button w3-block w3-green w3-section w3-padding" name="apply_register" type="submit" value="Yes">
    </div>
</form>