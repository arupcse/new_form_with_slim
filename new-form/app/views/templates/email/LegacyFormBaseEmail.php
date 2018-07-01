<div style="font-family:Arial, Helvetica, sans-serif;font-size:12px;">
    <h3 style="color: #C00000;">
        <strong>Information from legacy form</strong>
    </h3>
    <p>
        <strong>Full Name :</strong><?php echo $full_name;?>
    </p>
    <p>
        <strong>Email Address :</strong><?php echo $email;?>
    </p>
    <p>
        <strong>Comments :</strong><?php echo $comments;?>
    </p>
    <p>
        <strong>Student Type :</strong><?php echo $student_type;?>
    </p>
    <p>
        <strong>Student Interest :</strong><?php echo ucfirst(implode(',', $student_interest));?>
    </p>
    <p>
        <strong>Campus :</strong><?php echo $campus;?>
    </p>
    <p>
        <strong>Faculty :</strong><?php echo implode(',', $faculty);?>
    </p>
</div>
