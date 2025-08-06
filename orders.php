<h5 class="mb-3 text-center">Παραγγελίες</h5>
<div class="orders-table">
    <table style="width:100%" class="table-bordered text-center">
        <thead>
            <tr class="py-2">
                
                <th class="py-2">Αριθμός παραγγελίας</th>
                <th class="py-2">Κόστος</th>
                <th class="py-2">Ημερομηνία</th>
                <th class="py-2">Λεπτομέρειες</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = getOrders();

            if (mysqli_num_rows($orders) > 0) {
                foreach ($orders as $item) { ?>

                    <tr>
                        
                        <td><?php echo $item['tracking_no']; ?></td>
                        <td><?php echo $item['total_price']; ?>.00€</td>
                        <td><?php echo $item['created_at']; ?></td>
                        <td><a href="my-account?source=view-order&t=<?php echo $item['tracking_no']; ?>" class="btn btn-primary my-2">Δείτε την παραγγελία</a></td>
                    </tr>

                <?php }
            } else { 
                ?>

                <tr>
                    <td colspan="5">No orders yet</td>
                </tr> 


            <?php }

            ?>


        </tbody>
    </table>
</div>