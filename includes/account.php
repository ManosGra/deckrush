<div class="edit-account">

    <?php if (isset($_SESSION['auth']) && !empty($_SESSION['auth'])): ?>
              
        <p>Γεια σας <strong><?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?></strong>!
        (δεν είστε ο/η <strong><?php echo htmlspecialchars($_SESSION['auth_user']['username']); ?></strong>;
        <a href="logout" class="text-decoration-none text-danger">Αποσυνδεθείτε</a>)</p>
        <p>Από τον πίνακα ελέγχου του λογαριασμού σας μπορείτε να δείτε τις 
        <a class="text-decoration-none text-danger" href="my-account?source=orders">πρόσφατες παραγγελίες</a> σας
        και να επεξεργασθείτε τις<br><a class="text-decoration-none text-danger" href="my-account?source=edit-profile"> λεπτομέρειες του λογαριασμού σας</a>.
        </p>
    <?php else: ?>
        <p>Παρακαλώ συνδεθείτε για να δείτε τα στοιχεία του λογαριασμού σας.</p>
    <?php endif; ?>

</div>
