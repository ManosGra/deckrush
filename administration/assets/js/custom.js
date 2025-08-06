$(document).ready(function () {

    $(document).on('click', '.delete_product_btn', function (e) {
        e.preventDefault(); // Εδώ δηλώνουμε την παράμετρο 'e'

        var id = $(this).val();

        swal({
            title: "Είσαι σίγουρος;",
            text: "Αφού διαγραφεί, δεν θα μπορείς να το επαναφέρεις",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'product_id': id,
                        'delete_product_btn': true
                    },
                    success: function (response) {
                        console.log("Response from server: ", response); // Έλεγχος απόκρισης

                        if (response == 200) {
                            swal("Επιτυχία!", "Το προϊόν διαγράφηκε επιτυχώς!", "success")
                            .then(() => {
                                $("#products_table").html("Φορτώνει..."); // Προσωρινό μήνυμα
                                $("#products_table").load(location.href + " #products_table > *"); // Επαναφόρτωση του πίνακα
                            });
                        } else if (response == 500) {
                            swal("Σφάλμα!", "Κάτι πήγε στραβά!", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: ", error); // Έλεγχος σφάλματος
                        swal("Σφάλμα!", "Η διαγραφή απέτυχε!", "error");
                    }
                });
            }
        });
    });

    $(document).on('click', '.delete_category_btn', function (e) {
        e.preventDefault(); // Εδώ δηλώνουμε την παράμετρο 'e'

        var id = $(this).val();

        swal({
            title: "Είσαι σίγουρος;",
            text: "Αφού διαγραφεί, δεν θα μπορείς να το επαναφέρεις",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    method: "POST",
                    url: "code.php",
                    data: {
                        'category_id': id,
                        'delete_category_btn': true
                    },
                    success: function (response) {
                        console.log("Response from server: ", response); // Έλεγχος απόκρισης

                        if (response == 200) {
                            swal("Επιτυχία!", "Η κατηγορία διαγράφηκε επιτυχώς!", "success")
                            .then(() => {
                                $("#category_table").html("Φορτώνει..."); // Προσωρινό μήνυμα
                                $("#category_table").load(location.href + " #category_table > *"); // Επαναφόρτωση του πίνακα
                            });
                        } else if (response == 500) {
                            swal("Σφάλμα!", "Κάτι πήγε στραβά!", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: ", error); // Έλεγχος σφάλματος
                        swal("Σφάλμα!", "Η διαγραφή απέτυχε!", "error");
                    }
                });
            }
        });
    });
});
