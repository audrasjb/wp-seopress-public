<?php

defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

global $typenow;
global $pagenow;
$data_tax = '';

if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
    $current_id = get_the_id();
    $origin = 'post';

    function seopress_titles_single_cpt_date_option() {
        global $post;
        $seopress_get_current_cpt = get_post_type($post);

        $seopress_titles_single_cpt_date_option = get_option("seopress_titles_option_name");
        if ( ! empty ( $seopress_titles_single_cpt_date_option ) ) {
            foreach ($seopress_titles_single_cpt_date_option as $key => $seopress_titles_single_cpt_date_value)
                $options[$key] = $seopress_titles_single_cpt_date_value;
             if (isset($seopress_titles_single_cpt_date_option['seopress_titles_single_titles'][$seopress_get_current_cpt]['date'])) { 
                return $seopress_titles_single_cpt_date_option['seopress_titles_single_titles'][$seopress_get_current_cpt]['date'];
             }
        }
    }

    function seopress_display_date_snippet() {
        if (seopress_titles_single_cpt_date_option()) {
            return '<div class="snippet-date">'.get_the_date('M j, Y').' - </div>';
        }
    }
} elseif ( $pagenow =='term.php' || $pagenow =='edit-tags.php') {
    global $tag;
    $current_id = $tag->term_id;
    $origin = 'term';
    $data_tax = $tag->taxonomy;
    // function seopress_titles_title($seopress_titles_title) {
    //     global $tag;
    //     if ($seopress_titles_title !='') {
    //         return $seopress_titles_title;
    //     } elseif ($tag) {
    //         return $tag->name.' - '.get_bloginfo('name');
    //     } else {
    //         return get_the_title().' - '.get_bloginfo('name');
    //     }
    // }

    // function seopress_titles_single_desc_option() {
    //     global $post;
    //     $seopress_get_current_cpt = get_post_type($post);

    //     $seopress_titles_single_desc_option = get_option("seopress_titles_option_name");
    //     if ( ! empty ( $seopress_titles_single_desc_option ) ) {
    //         foreach ($seopress_titles_single_desc_option as $key => $seopress_titles_single_desc_value)
    //             $options[$key] = $seopress_titles_single_desc_value;
    //             if (isset($seopress_titles_single_desc_option['seopress_titles_single_titles'][$seopress_get_current_cpt]['description'])) {
    //                 return $seopress_titles_single_desc_option['seopress_titles_single_titles'][$seopress_get_current_cpt]['description'];
    //             }
    //     }
    // }

    // function seopress_titles_desc($seopress_titles_desc) {
    //     global $tag;
    //     if ($seopress_titles_desc !='') {
    //         return $seopress_titles_desc;
    //     } elseif ($tag) {
    //         return $tag->description;
    //     }
    // }
}

function seopress_redirections_value($seopress_redirections_value) {
    if ($seopress_redirections_value !='') {
        return $seopress_redirections_value;
    }
}

if ( $pagenow =='term.php' || $pagenow =='edit-tags.php') {
    echo '
        <tr id="term-seopress" class="form-field">
            <th scope="row">'.__('SEO','wp-seopress').'</th>
            <td>
                <div id="seopress_cpt">
                    <div class="inside">';
}

echo '<div id="seopress-tabs" data_id="'.$current_id.'" data_origin="'.$origin.'" data_tax="'.$data_tax.'">';
     echo'<ul>';
            if ("seopress_404" != $typenow) {
                echo '<li><a href="#tabs-1"><span class="dashicons dashicons-editor-table"></span>'. __( 'Titles settings', 'wp-seopress' ) .'</a></li>
                <li><a href="#tabs-2"><span class="dashicons dashicons-admin-generic"></span>'. __( 'Advanced', 'wp-seopress' ) .'</a></li>
                <li><a href="#tabs-3"><span class="dashicons dashicons-share"></span>'. __( 'Social', 'wp-seopress' ) .'</a></li>';
            }
            echo '<li><a href="#tabs-4"><span class="dashicons dashicons-admin-links"></span>'. __( 'Redirection', 'wp-seopress' ) .'</a></li>';
            if (is_plugin_active( 'wp-seopress-pro/seopress-pro.php' )) {
                if (seopress_get_toggle_news_option() =='1') {
                    if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                        if ("seopress_404" != $typenow) {
                            echo '<li><a href="#tabs-5"><span class="dashicons dashicons-admin-post"></span>'. __( 'Google News', 'wp-seopress-pro' ) .'</a></li>';
                        }
                    }
                }
            }
        echo '</ul>';
        
        if ("seopress_404" != $typenow) {
        echo '<div id="tabs-1">';
            if (is_plugin_active( 'woocommerce/woocommerce.php' )) {
                $shop_page_id = wc_get_page_id( 'shop' );
                if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                    if ( $post && absint( $shop_page_id ) === absint( $post->ID ) ) {
                        echo '<p class="notice notice-info">'.__('This is your <strong>Shop page</strong>. Go to <strong>SEO > Titles & Metas > Archives > Products</strong> ','wp-seopress').' <a href="'.admin_url( 'admin.php?page=seopress-titles' ).'">'.__('to edit your title and meta description','wp-seopress').'</a></p>';
                    }
                }
            }
        echo '<div class="box-left">
                <p>
                    <label for="seopress_titles_title_meta">'. __( 'Title', 'wp-seopress' ) .'</label>
                    <input id="seopress_titles_title_meta" type="text" name="seopress_titles_title" placeholder="'.esc_html__('Enter your title','wp-seopress').'" aria-label="'.__('Title','wp-seopress').'" value="'.$seopress_titles_title.'" />
                </p> 
                <div class="wrap-seopress-counters">
                    <div id="seopress_titles_title_counters"></div>
                    '.__('(maximum recommended limit)','wp-seopress').'
                </div>
                <p>
                    <label for="seopress_titles_desc_meta">'. __( 'Meta description', 'wp-seopress' ) .'</label>
                    <textarea id="seopress_titles_desc_meta" style="width:100%" rows="8" name="seopress_titles_desc" placeholder="'.esc_html__('Enter your meta description','wp-seopress').'" aria-label="'.__('Meta description','wp-seopress').'" value="'.$seopress_titles_desc.'">'.$seopress_titles_desc.'</textarea>
                </p>
                <div class="wrap-seopress-counters">
                    <div id="seopress_titles_desc_counters"></div>
                    '.__('(maximum recommended limit)','wp-seopress').'
                </div>
            </div>
            <div class="box-right">
                <div class="google-snippet-preview">
                    <h3>'.__('Google Snippet Preview','wp-seopress').'</h3>
                    <p>'.__('This is what your page will look like in Google search results','wp-seopress').'</p>
                    <div class="snippet-title"></div>
                    <div class="snippet-title-custom" style="display:none"></div>';
                global $tag;
                if (get_the_title()) {
                    echo '<div class="snippet-title-default" style="display:none">'.get_the_title().' - '.get_bloginfo('name').'</div>
                    <div class="snippet-permalink">'.get_permalink().'</div>';
                } elseif ($tag) {
                    echo '<div class="snippet-title-default" style="display:none">'.$tag->name.' - '.get_bloginfo('name').'</div>';
                    echo '<div class="snippet-permalink">'.get_term_link($tag).'</div>';
                }

                if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
echo                seopress_display_date_snippet();
                }
echo               '<div class="snippet-description">...</div>
                    <div class="snippet-description-custom" style="display:none"></div>
                    <div class="snippet-description-default" style="display:none"></div>';
            echo '</div>
            </div>
        </div>
        <div id="tabs-2">
            <p>
                <label for="seopress_robots_index_meta">
                    <input type="checkbox" name="seopress_robots_index" id="seopress_robots_index_meta" value="yes" '. checked( $seopress_robots_index, 'yes', false ) .' />
                        '. __( 'noindex', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not display all pages of the site in Google search results and do not display "Cached" links in search results.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_follow_meta">
                    <input type="checkbox" name="seopress_robots_follow" id="seopress_robots_follow_meta" value="yes" '. checked( $seopress_robots_follow, 'yes', false ) .' />
                        '. __( 'nofollow', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not follow links for all pages.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_odp_meta">
                    <input type="checkbox" name="seopress_robots_odp" id="seopress_robots_odp_meta" value="yes" '. checked( $seopress_robots_odp, 'yes', false ) .' />
                        '. __( 'noodp', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not use Open Directory project metadata for titles or excerpts for all pages.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_imageindex_meta">
                    <input type="checkbox" name="seopress_robots_imageindex" id="seopress_robots_imageindex_meta" value="yes" '. checked( $seopress_robots_imageindex, 'yes', false ) .' />
                        '. __( 'noimageindex', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not index images from the entire site.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_archive_meta">
                    <input type="checkbox" name="seopress_robots_archive" id="seopress_robots_archive_meta" value="yes" '. checked( $seopress_robots_archive, 'yes', false ) .' />
                        '. __( 'noarchive', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not display a "Cached" link in the Google search results.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_snippet_meta">
                    <input type="checkbox" name="seopress_robots_snippet" id="seopress_robots_snippet_meta" value="yes" '. checked( $seopress_robots_snippet, 'yes', false ) .' />
                        '. __( 'nosnippet', 'wp-seopress' ) .'
                </label><span class="dashicons dashicons-info" title="'.esc_html(__('Do not display a description in the Google search results for all pages.','wp-seopress')).'"></span>
            </p>
            <p>
                <label for="seopress_robots_canonical_meta">'. __( 'Canonical URL', 'wp-seopress' ) .'</label>
                <input id="seopress_robots_canonical_meta" type="text" name="seopress_robots_canonical" placeholder="'.esc_html__('Default value: ','wp-seopress').get_permalink().'" aria-label="'.__('Canonical URL','wp-seopress').'" value="'.$seopress_robots_canonical.'" />
            </p>';
            if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                if (is_plugin_active('wp-seopress-pro/seopress-pro.php')) {
                    echo '<p>
                        <label for="seopress_robots_breadcrumbs_meta">'. __( 'Custom breadcrumbs', 'wp-seopress' ) .'</label>
                        <input id="seopress_robots_breadcrumbs_meta" type="text" name="seopress_robots_breadcrumbs" placeholder="'.esc_html__('Enter a custom value, useful if your title is too long','wp-seopress').'" aria-label="'.__('Custom breadcrumbs','wp-seopress').'" value="'.$seopress_robots_breadcrumbs.'" />
                    </p>';
                }
            }
        echo '</div>
        <div id="tabs-3">
            <span class="dashicons dashicons-facebook-alt"></span>
            <br><br>
            <span class="dashicons dashicons-external"></span><a href="https://developers.facebook.com/tools/debug/sharing/?q='.get_permalink(get_the_id()).'" target="_blank">'.__('Ask Facebook to update his cache','wp-seopress').'</a>
            <p>
                <label for="seopress_social_fb_title_meta">'. __( 'Facebook Title', 'wp-seopress' ) .'</label>
                <input id="seopress_social_fb_title_meta" type="text" name="seopress_social_fb_title" placeholder="'.esc_html__('Enter your Facebook title','wp-seopress').'" aria-label="'.__('Facebook Title','wp-seopress').'" value="'.$seopress_social_fb_title.'" />
            </p>
            <p>
                <label for="seopress_social_fb_desc_meta">'. __( 'Facebook description', 'wp-seopress' ) .'</label>
                <textarea id="seopress_social_fb_desc_meta" name="seopress_social_fb_desc" placeholder="'.esc_html__('Enter your Facebook description','wp-seopress').'" aria-label="'.__('Facebook description','wp-seopress').'" value="'.$seopress_social_fb_desc.'">'.$seopress_social_fb_desc.'</textarea>
            </p> 
            <p>
                <label for="seopress_social_fb_img_meta">'. __( 'Facebook Thumbnail', 'wp-seopress' ) .'</label>
                <span class="advise">'. __('Minimum size: 200x200px', 'wp-seopress') .'</span>
                <input id="seopress_social_fb_img_meta" type="text" name="seopress_social_fb_img" placeholder="'.esc_html__('Select your default thumbnail','wp-seopress').'" aria-label="'.__('Facebook Thumbnail','wp-seopress').'" value="'.$seopress_social_fb_img.'" />
                <input id="seopress_social_fb_img_upload" class="button" type="button" value="'.__('Upload an Image','wp-seopress').'" />
            </p>
            <br/>
            <span class="dashicons dashicons-twitter"></span>
            <p>
                <label for="seopress_social_twitter_title_meta">'. __( 'Twitter Title', 'wp-seopress' ) .'</label>
                <input id="seopress_social_twitter_title_meta" type="text" name="seopress_social_twitter_title" placeholder="'.esc_html__('Enter your Twitter title','wp-seopress').'" aria-label="'.__('Twitter Title','wp-seopress').'" value="'.$seopress_social_twitter_title.'" />
            </p>
            <p>
                <label for="seopress_social_twitter_desc_meta">'. __( 'Twitter description', 'wp-seopress' ) .'</label>
                <textarea id="seopress_social_twitter_desc_meta" name="seopress_social_twitter_desc" placeholder="'.esc_html__('Enter your Twitter description','wp-seopress').'" aria-label="'.__('Twitter description','wp-seopress').'" value="'.$seopress_social_twitter_desc.'">'.$seopress_social_twitter_desc.'</textarea>
            </p> 
            <p>
                <label for="seopress_social_twitter_img_meta">'. __( 'Twitter Thumbnail', 'wp-seopress' ) .'</label>
                <span class="advise">'. __('Minimum size: 160x160px', 'wp-seopress') .'</span>
                <input id="seopress_social_twitter_img_meta" type="text" name="seopress_social_twitter_img" placeholder="'.esc_html__('Select your default thumbnail','wp-seopress').'" value="'.$seopress_social_twitter_img.'" />
                <input id="seopress_social_twitter_img_upload" class="button" type="button" aria-label="'.__('Twitter Thumbnail','wp-seopress').'" value="'.__('Upload an Image','wp-seopress').'" />
            </p>
        </div>';
        }

        echo '<div id="tabs-4">
            <p>
                <label for="seopress_redirections_enabled_meta" id="seopress_redirections_enabled">
                    <input type="checkbox" name="seopress_redirections_enabled" id="seopress_redirections_enabled_meta" value="yes" '. checked( $seopress_redirections_enabled, 'yes', false ) .' />
                        '. __( 'Enable redirection?', 'wp-seopress' ) .'
                </label>
            </p>
            <p>
                <label for="seopress_redirections_value_meta">'. __( 'URL redirection', 'wp-seopress' ) .'</label>
                <select name="seopress_redirections_type">
                    <option ' . selected( '301', $seopress_redirections_type, false ) . ' value="301">'. __( '301 Moved Permanently', 'wp-seopress' ) .'</option>
                    <option ' . selected( '302', $seopress_redirections_type, false ) . ' value="302">'. __( '302 Found (HTTP 1.1) / Moved Temporarily (HTTP 1.0)', 'wp-seopress' ) .'</option>
                    <option ' . selected( '307', $seopress_redirections_type, false ) . ' value="307">'. __( '307 Moved Temporarily (HTTP 1.1 Only)', 'wp-seopress' ) .'</option>
                </select>
                <input id="seopress_redirections_value_meta" type="text" name="seopress_redirections_value" placeholder="'.esc_html__('Enter your new URL','wp-seopress').'" aria-label="'.__('URL redirection','wp-seopress').'" value="'.$seopress_redirections_value.'" />
                <br><br>';
                if ($seopress_redirections_value !='' && $seopress_redirections_enabled =='yes') {
                    if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                        if ( 'seopress_404' == $typenow ) {                      
                            echo '<a href="'.get_home_url().'/'.get_the_title().'/" id="seopress_redirections_value_default" class="button" target="_blank">'.__('Test your URL','wp-seopress').'</a>';
                        } else {
                            echo '<a href="'.get_permalink().'" id="seopress_redirections_value_default" class="button" target="_blank">'.__('Test your URL','wp-seopress').'</a>';
                        }
                    } elseif ( $pagenow == 'term.php' ) {
                        echo '<a href="'.get_term_link($term).'" id="seopress_redirections_value_default" class="button" target="_blank">'.__('Test your URL','wp-seopress').'</a>';
                    } else {
                        echo '<a href="'.get_permalink().'" id="seopress_redirections_value_default" class="button" target="_blank">'.__('Test your URL','wp-seopress').'</a>';
                    }
                }
echo            '</p>
        </div>';
    if (is_plugin_active( 'wp-seopress-pro/seopress-pro.php' )) {
        if (seopress_get_toggle_news_option() =='1') {
            if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                if ("seopress_404" != $typenow) { 
                    echo '<div id="tabs-5">
                        <p>
                            <label for="seopress_news_disabled_meta" id="seopress_news_disabled">
                                <input type="checkbox" name="seopress_news_disabled" id="seopress_news_disabled_meta" value="yes" '. checked( $seopress_news_disabled, 'yes', false ) .' />
                                    '. __( 'Exclude this post from Google News Sitemap?', 'wp-seopress' ) .'
                            </label>
                        </p>
                        <p>
                            <label for="seopress_news_standout_meta" id="seopress_news_standout">
                                <input type="checkbox" name="seopress_news_standout" id="seopress_news_standout_meta" value="yes" '. checked( $seopress_news_standout, 'yes', false ) .' />
                                    '. __( 'Use the standout tag for this post?', 'wp-seopress' ) .'
                            <span class="dashicons dashicons-info" title="'.esc_html(__('Your article is an original source for the story.
Your organization invested significant resources in reporting or producing the article.
The article deserves special recognition.
You haven\'t used standout on your own articles more than seven times in the past calendar week.','wp-seopress')).'"></span>
                            </label>';
                            
                            if (function_exists('seopress_get_locale')) {
                                if (seopress_get_locale() =='fr') {
                                    $seopress_docs_link = 'https://support.google.com/news/publisher/answer/191283?hl=fr';
                                } else {
                                    $seopress_docs_link = 'https://support.google.com/news/publisher/answer/191283';
                                }
                            }
                            
                            echo '<span class="dashicons dashicons-external"></span><a href="'.$seopress_docs_link.'" target="_blank" class="seopress-doc">'.__('Learn how to use correctly the standout tag','wp-seopress').'</a>
                        </p>
                        <p>
                            <label for="seopress_news_genres_meta">'. __( 'Google News Genres', 'wp-seopress' ) .'</label>
                            <select name="seopress_news_genres">
                                <option ' . selected( 'none', $seopress_news_genres, false ) . ' value="none">'. __( 'None', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'pressrelease', $seopress_news_genres, false ) . ' value="pressrelease">'. __( 'Press Release', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'satire', $seopress_news_genres, false ) . ' value="satire">'. __( 'Satire', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'blog', $seopress_news_genres, false ) . ' value="blog">'. __( 'Blog', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'oped', $seopress_news_genres, false ) . ' value="oped">'. __( 'OpEd', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'opinion', $seopress_news_genres, false ) . ' value="opinion">'. __( 'Opinion', 'wp-seopress' ) .'</option>
                                <option ' . selected( 'usergenerated', $seopress_news_genres, false ) . ' value="usergenerated">'. __( 'UserGenerated', 'wp-seopress' ) .'</option>
                            </select>
                        </p>
                        <p>
                            <label for="seopress_news_keyboard_meta" id="seopress_news_keyboard">
                                '. __( 'Google News Keywords <em>(max recommended limit: 12)</em>', 'wp-seopress' ) .'</label>
                                <input id="seopress_news_keyboard_meta" type="text" name="seopress_news_keyboard" placeholder="'.esc_html__('Enter your Google News Keywords','wp-seopress').'" aria-label="'.__('Google News Keywords <em>(max recommended limit: 12)</em>','wp-seopress').'" value="'.$seopress_news_keyboard.'" />
                        </p>
                    </div>';
                }
            }
        }
    }
    echo '</div>';

if ( $pagenow =='term.php' || $pagenow =='edit-tags.php') {
                echo '</div>';
            echo '</div>';
        echo '</td>';
    echo '</tr>';
}
