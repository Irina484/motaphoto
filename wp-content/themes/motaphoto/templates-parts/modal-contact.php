
<!-- The Modal -->
<div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  
          <div class="modal-header">
           <div class="image-container">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/contact_modale_desktop.png" alt="Le mot CONTACT">
           </div>   
          </div>
      <div class="modal-body">
        <div class="form-container">
          <?php
            echo do_shortcode('[contact-form-7 id="a56b895" title="Formulaire de contact"]');
              
          ?>
        </div>
      </div>
  </div>
</div>
</div>

