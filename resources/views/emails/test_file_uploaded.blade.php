<!DOCTYPE html>
<html>
<head>
    <title>Test File Uploaded</title>
</head>
<body>
    <h2>Medical Test File Uploaded</h2>
    <p>Dear {{ $appointment->patient->user->name }},</p>

    <p>A medical test file has been successfully uploaded for your appointment (ID: {{ $appointment->id }}) with Dr. {{ $appointment->doctor->user->name }}.</p>

    <p>You can now view or download it by logging into your portal.</p>

    <p>Thank you,<br>Medinova Hospoital</p>
</body>
</html>
