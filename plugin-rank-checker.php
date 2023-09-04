<?php 

// Define the shortcode function to display the plugin rank based on the local language.
function custom_plugin_rank_local_shortcode() {
    $current_locale = get_locale();

    $keyword = 'WRITE YOUR KEYWORD HERE';
    $per_page = 100; 
    $url = "https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&request[per_page]={$per_page}&request[search]={$keyword}&locale={$current_locale}";

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
        return "Error: Unable to fetch plugin rank.";
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['plugins']) && is_array($data['plugins']) && !empty($data['plugins'])) {
        $rank = 0; // Default rank 

        foreach ($data['plugins'] as $index => $plugin) {
            if ($plugin['slug'] === 'WRITE THE PLUGIN SLUG HERE') {
                $rank = $index + 1; 
                break;
            }
        }

        // Format and print the information.
        $output = "For locale {$current_locale}, the rank of the plugin for the keyword '{$keyword}' is '{$rank}'.";
        return $output;
    } else {
        return "No plugins found for the keyword '{$keyword}' in locale {$current_locale}.";
    }
}

// Register the shortcode.
add_shortcode('plugin_rank_local', 'custom_plugin_rank_local_shortcode');

?>