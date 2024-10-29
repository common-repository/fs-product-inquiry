<?php

defined('ABSPATH') || exit;

 /*
 * Template Name: FSPI Single Product
 */
get_header(); 
?>
<div class="fspi-product-detail">
    <div id="fspi-product-detail-content" >
        <div class="container">
            <div class="row">
                <!-- The Modal -->
                <div class="modal fspi-modal" id="fspi-model">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <!-- Modal body -->
                      <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                       <?php include FSPI_BASE_DIR.'templates/public/fspi-show-inquiry-form.php'; ?> 
                      </div>
                    </div>
                  </div>
                </div>
                <!-- close model -->
                <div class="col-md-6 mb-4">
                  <div class="fspi-product-image">
                    <div class="p-4">
                      <img src="<?php 
                                  if(has_post_thumbnail(get_the_ID())){
                                    echo wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'thumbnail' );
                                  }else{
                                    echo FSPI_BASE_URL.'assets/public/img/product.png';
                                  }
                                ?>" class="img-fluid" alt="">
                    </div>
                  </div>
                </div>
                <div class="col-md-6 mb-4">
                  <!--Content--> 
                  <div class="p-4">
                    <div class="fspi-product-description">
                      <?= !empty($_POST['fspi_msg'])?sanitize_text_field($_POST['fspi_msg']):''; ?>
                    <h3 class="lead font-weight-bold"><?= the_title() ?></h3>
                    <span class="lead">
                      <span class="mr-1">
                        <del><?= get_option("_fspi_product_currency") ?> <?= get_post_meta(get_the_ID(),'_fs_product_price',true); ?></del>
                      </span>
                      <span><?= get_option("_fspi_product_currency") ?> <?= get_post_meta(get_the_ID(),'_fs_product_selling_price',true); ?></span>
                    </span>
                    <br>
                    <b class="label"><?= __('Short Description','fspi') ?></b>
                    <p><?= get_post_meta(get_the_ID(),'_fs_short_description',true); ?></p>
                    <div class="mb-3">
                      <?php
                        $parents = get_the_terms( get_the_ID(), 'attributes' );
                        $categories = $parents;
                        if(!empty($parents)){
                          echo '<b class="label">Attributes</b>';
                          foreach( $parents as $parent ): 
                            if($parent->parent == 0){ ?>
                            <div class="alert alert-secondary fspi-alert">
                              <?= '<strong>' . $parent->name . '</strong>: '; ?>
                              <span style="float: right;">
                                <?php 
                                  $links = array();
                                  foreach( $categories as $category ):
                                      if( $parent->term_id == $category->parent ):
                                          $links[] =  $category->name;
                                      endif;
                                  endforeach;
                                  echo join( ', ', $links ); 
                                ?>
                              </span>
                            </div>
                          <?php } 
                          endforeach; 
                        }
                      ?>
                    </div>
                    <div class="product-grid8">
                      <?php  if(!empty(get_option('_fspi_inquiry_form_open_in_popup'))){?>
                        <button class="all-deals" style="width: 100%" onclick="javascript:fspiCK('<?= get_the_ID() ?>')"><?= __('Inquiry','fspi') ?> <div class="fspi-loader fspi-loader-<?= get_the_ID() ?>" style="display: none;"></div></button>
                        <?php
                      }else{
                      ?>
                      <form action="" method="post">
                        <input type="hidden" name="_fs_product_id" value="<?= get_the_ID() ?>">
                        <button class="all-deals" style="width: 100%"><?= __('Inquiry','fspi') ?></button>
                      </form>
                    <?php } ?>
                    </div>
                  </div>
                  </div>
                  <!--Content-->
                </div>
            </div>
          
            <div class="row">
              <div style="width: 100%" class="fspi-descriptn-reviw">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="fspi-longdescrptn-tab" data-toggle="tab" href="#fspi-longdescrptn" role="tab" aria-controls="fspi-longdescrptn" aria-selected="true"><?= __('Description','fspi'); ?></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="fspi-review-tab" data-toggle="tab" href="#fspi-review" role="tab" aria-controls="fspi-review" aria-selected="false"><?= __('Reviews','fspi') ?></a>
                  </li>
                </ul>
                  <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade active in" id="fspi-longdescrptn" role="tabpanel" aria-labelledby="home-tab">
                    <h3><?= __('Long description','fspi'); ?></h3>
                    <p><?php 
                    $content_post = get_post(get_the_ID());
                    $content = $content_post->post_content; 
                    echo __($content,'fspi');
                    ?></p>
                  </div>
                  <div class="tab-pane fade" id="fspi-review" role="tabpanel" aria-labelledby="profile-tab">
                    <h3><?= __('Review','fspi') ?></h3>
                    <?php if( is_single() ) : ?>
                    <?php  foreach (get_comments(array('post_id'=>get_the_ID())) as $comment): ?>
                        <div class="alert alert-secondary" role="alert" >
                          <span class="pull-left"><?php echo __($comment->comment_content,'fspi'); ?></span>
                            <?php 
                            if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
                              $stars = '<p class="stars">';
                              for ( $i = 1; $i <= $rating; $i++ ) {
                                $stars .= '<span class="dashicons dashicons-star-filled"></span>';
                              }
                              $stars .= '</p>';
                              echo $stars;
                            }
                            ?>
                            <br>
                            <span><b><?php echo __($comment->comment_author,'fspi'); ?></b></span>
                        </div>
                        <?php endforeach; ?>
                        <div class="row fspi-comment-form">
                          <div class="col-md-6">
                            <?php comment_form(); ?>
                          </div>
                        </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>


