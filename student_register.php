<form class="w3-container" action="student_register_success.php" method="POST">
    <div class="w3-section">
        <input type="hidden" name="requestId" value="<?= $requestId;?>">
        <input type="hidden" name="studentId" value="<?= $student_id;?>">
        <label><b>Start Date</b></label>
        <input class="w3-input w3-border w3-margin-bottom" type="date" name="startDate" required>
        <label><b>End Date</b></label>
        <input class="w3-input w3-border" type="date" name="endDate" required>
        <input class="w3-button w3-block w3-green w3-section w3-padding" name="apply_register" type="submit" value="Register">
    </div>
</form>