<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/javascript/jquery/jquery-cookie/jquery.cookie.js"></script>
<script src="<?php echo base_url() ?>assets/javascript/jquery/jquery-ui-1.10.3.custom.min.js"></script>
<script>

    /*
     * Highlight whitespaces and linebreaks, remove highlight when submit form
     */

        var $text = $( "#text" ),
            highlight = function() {
                $text.val($text.val()
                .replace(/(\r\n|\n|\v)/g,"¶$1")
                .replace(/\x20/g,"•")
                .replace(/\t/g," → "));
        },

            removeHighlight = function() {
                $text.val($text.val()
                .replace(/¶/g,"")
                .replace(/•/g,"\x20")
                .replace(/ → /g,"\t"));
        };

    /*
     *  Promt when deleting catgegory or group
     */

    /* TODO: do not prompt if no children */
    (function() {
        $( ".category-controls .delete" ).click(function() {
            if ( window.confirm( "<?php echo lang('category_confirm_delete') ?>" ) ) {
                removeHighlight();
                return true;
            }
            return false;
        });

        $( ".group" ).children( ".delete" ).click(function() {
            if ( window.confirm( "<?php echo lang('group_confirm_delete') ?>" ) ) {
                removeHighlight();
                return true;
            }
            return false;
        });
    })();

    /*
     * Highlight whitespaces and linebreaks, remove highlight when submit form
     *
     * Continued
     */

    (function() {

        var $checkbox = $( "#highlight-result" ),
            $button = $( "button[name='action']" ).not( ".delete.c, .delete.g" );
            
        if ( $.cookie( "highlight-result" ) === "on" ) {
            $checkbox.attr( "checked", true);

            if (typeof $text.val() != "undefined") {
                highlight();
            }
            
            $text.on( "focusout", highlight);
            $text.on( "focus", removeHighlight);
        } else {
            $checkbox.attr( "checked", false);
        };

        $checkbox.on( "change", function() {

            if ($checkbox.is( ":checked" )) {

                $.cookie( "highlight-result", "on", { expires: 365, path: "/" });
                highlight();
                $text.on( "focusout", highlight);
                $text.on( "focus", removeHighlight);
            } else {

            $.cookie( "highlight-result", "off", { expires: 365, path: "/" });
                removeHighlight();
                $text.unbind();
            }
        });

        $button.on( "click", function(event) {
            //event.preventDefault();
            removeHighlight();
            //$(this).unbind( "click" ).trigger( "click" );
        })

    })();


    /*
     * Remember current location when changing language, remove highlight
     */

    (function() {
        var $button = $( "#toggle-language" );

        $button.on( "click", function(e) {
            e.preventDefault();

            var $form = $( "<form action=\"<?php echo base_url('index.php/editor_actions/action')?>\" method=\"post\" accept-charset=\"utf-8\"><form>" ),
                $input = $( "<input>" ).attr( "type", "hidden" ).attr( "name", "action" ).val("toggle_language");
            $form.append( $input );

            $.cookie( "path", $(location).attr('href') , { path: "/" });

           if (typeof $text.val() != "undefined") {
                removeHighlight();
            }

            $form.submit();
        });
    })();

    
    /*
     * Test regex_rule on-fly
     */

    (function() {

        var $form = $( ".rule.form" ),
            $type = $form.find( "[name='rule_type']" ),
            $delim = $form.find( "[name='rule_separator']" ),
            $modifiers = $form.find( "[name='rule_modifiers']" ),
            $textarea = $form.find( "textarea[name='rule_pattern']" ),

        checkRegex = function() {
            if ($type.filter( ":checked" ).val() == "regex") {
                $.post(
                    "<?php echo base_url('index.php/editor_actions/action');?>",
                    "action=test_regex_rule&regex=" + encodeURIComponent($delim.val() + $textarea.val() + $delim.val() + $modifiers.val()),
                    function( data ) {
                        if ( data ) {
                            $textarea.addClass( "input-error" );
                        } else {
                            $textarea.removeClass( "input-error" );
                        };
 //                       console.log( data );
                    }
                );
            } else {
                $textarea.removeClass( "input-error" );
            }
        };
            
        checkRegex();
        $textarea.on( "input", checkRegex);
        $delim.on( "input", checkRegex);
        $modifiers.on( "input", checkRegex);
        $type.on( "change", checkRegex);
        
    })();

    /*
    * Changing category
    */
    
    (function() {

        $( ".category-controls button[value='select_category']" ).hide();
        var $select = $( "select[name='category_id']" );
        $select.on( "change", function() {
            $( "#choose" ).trigger( "click" );
        })

    })();

    /*
    * Prevent action for disabled links
    */

    (function() {
        $( ".disabled" ).on( "click", function(e) {
            e.preventDefault();
        })
    })();

    /*
    * Making rules sortable, sending id and the new position to the server
    */

    (function() {
        var rules = $( ".rules" );
        rules.find( ".handle" ).css( "cursor", "move");
        rules.sortable({
            axis: "y",
            handle: ".handle",
            stop: function(event, ui) {

                $(this).find( ".rule-order" ).each( function(index, value) {
                    $(value).text('<?php echo lang('rule_order_sign') ?>' + (index+1));
                });

                var json = ('{"id":' + ui.item.attr('id') + ',"order":' + (ui.item.index() + 1) + '}');
                $.post(
                    "<?php echo base_url('index.php/editor_actions/action');?>",
                    "action=json_change_rule_order/" + json
                 );
            }
        });
    })();
    
     (function() {
        /*
        * Button toggler object
        */

        var buttonToggler = {

           config: {
               button:       "",
               elements:       "",
               coockieName:    "",
               coockieExpire:  "",
               hiddenTitle: "",
               shownTitle: "",
               effect: "slideToggle",
               duration: 300
           },

           init: function (config) {

               $.extend(this.config, config);

               var $button = $( this.config.button ),
                   $elements = $( this.config.elements ),
                   cookieName = this.config.coockieName,
                   coockieExpire = this.config.coockieExpire,
                   hiddenTitle = this.config.hiddenTitle,
                   shownTitle = this.config.shownTitle,
                   effect = this.config.effect,
                   duration = this.config.duration;

               if ( $.cookie(cookieName) === "visible" ) {
                   $button.attr( "title", shownTitle );
                   $elements.removeClass( "hidden" );
               } else {
                   $button.attr( "title", hiddenTitle );
                   $elements.addClass( "hidden" );
               };

               $button.on( "click", function(event) {
                   event.preventDefault();

                   if ( $button.attr( "title" ) === hiddenTitle ) {

                       $.cookie( cookieName, "visible", { expires: coockieExpire });
                       $elements[effect](duration);
                       $button.attr( "title", shownTitle );

                   } else {

                       $.cookie( cookieName, "hidden", { expires: coockieExpire });
                       $elements[effect](duration);
                       $button.attr( "title", hiddenTitle );
                   }
               });
           }
       },

       /*
        * Toggle global groups visibility
        */

        globalGroups = $( ".group.global" ).filter( function() {
           return $(this).data( "category-id" ) != $( "select#category_id" ).val();
        });

        buttonToggler.init({
           button:       "#toggle-global-groups",
           elements:      globalGroups,
           coockieName:    "global-groups",
           coockieExpire:  365,
           hiddenTitle: "<?php echo lang('category_show_global_groups') ?>",
           shownTitle: "<?php echo lang('category_hide_global_groups') ?>",
           effect: "slideToggle"
        });

       /*
       * Toggle info
       */

       buttonToggler.init({
           button:       ".toggle-info",
           elements:       ".info",
           coockieName:    "info",
           coockieExpire:  365,
           hiddenTitle: "<?php echo lang('category_show_info') ?>",
           shownTitle: "<?php echo lang('category_hide_info') ?>",
           effect: "fadeToggle"
        });

        (function() {
            $( "#info button.close").on( "click", function(event) {
                event.preventDefault();

            })
        })();
     })();

</script>
</body>
</html>