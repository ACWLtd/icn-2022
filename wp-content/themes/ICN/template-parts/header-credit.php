<?php
/**
 * Created by PhpStorm.
 * User: Ella
 * Date: 23/01/2019
 * Time: 11:22
 */

$show_header_image_credit = get_field('show_header_image_credit');
$credit = get_field('credit');

 if( $show_header_image_credit ): ?>
    <div class="page-image-credit" style="position: absolute; top: 520px; right: 1%; z-index: 99;max-width: 340px; line-height: 14px; ">
        <?php if($credit['credit_link']): ?>
            <a href="<?= $credit['credit_link']; ?>" target="_blank" style="color: white; font-size: 9px; "><?= $credit['credit_text']; ?></a>
        <?php else: ?>
            <div style="font-size: 9px; color: white !important;"><?= $credit['credit_text']; ?></div>
        <?php endif; ?>
    </div>
<?php endif; ?>