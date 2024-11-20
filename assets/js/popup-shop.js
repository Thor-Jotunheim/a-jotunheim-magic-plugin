jQuery(document).ready(function ($) {

    // Register new player
    $('#register-player-btn').on('click', function () {
        var playerName = $('#player').val();
        if (playerName) {
            $.ajax({
                url: jotunheimMagicAjax.ajax_url,
                type: 'POST',
                data: {
                    action: 'register_player',
                    player_name: playerName
                },
                success: function (response) {
                    if (response.success) {
                        alert('Player registered successfully!');
                        // Optionally, update the player dropdown here
                    } else {
                        alert('Error registering player.');
                    }
                },
                error: function () {
                    alert('Error registering player.');
                }
            });
        } else {
            alert('Please enter a player name.');
        }
    });

    // Save gold and Ymir flesh values
    $('#save-shop-btn').on('click', function () {
        var ymirFlesh = $('#ymir-flesh').val();
        var gold = $('#gold').val();

        $.ajax({
            url: jotunheimMagicAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'save_shop_data',
                ymir_flesh: ymirFlesh,
                gold: gold
            },
            success: function (response) {
                if (response.success) {
                    alert('Shop data saved successfully!');
                } else {
                    alert('Error saving shop data.');
                }
            },
            error: function () {
                alert('Error saving shop data.');
            }
        });
    });
});