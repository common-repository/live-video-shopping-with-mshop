<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap mshop-wrap sign-up_list">
    <h1>Users clicks Insight </h1>
    <div class="container mshop_list_inner">
        <h2>Clicks </h2>

        <?php if( !empty($jsonData)): ?>
        <table id="clicks_users" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Product link</th>
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=1; 
                    foreach($jsonData as $webform):
                    ?>
                <tr>
                    <td><?php echo esc_html($webform['name']); ?></td>
                    <td><?php echo esc_html($webform['email']); ?></td>
                    <td><?php echo esc_html($webform['product_link']); ?></td>
                    <td><?php echo esc_html($webform['address']); ?></td>
                    <td><?php echo esc_html($webform['phoneNumber']); ?></td>
                </tr>
                <?php 
                 endforeach;
                
                 ?>

            </tbody>
            <tfoot>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Product link</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>

            </tfoot>
        </table>
        <?php 
               
                 endif; 
                 ?>

    </div>
</div>
<script>
jQuery(document).ready(function($) {
    $('#clicks_users').DataTable();
});
</script>