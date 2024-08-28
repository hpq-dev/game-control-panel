<?php 
if(!isset($_SESSION['LOGGED'])) {
    Config::redirectEx('login');
    exit;
}

?>
        <div class="pcoded-wrapper">
            <div class="box-breadcrump">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item breadcrumb__item-firstChild">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Home</span>
                        </span>
                    </li>
                    <li class="breadcrumb__item">
                        <span class="breadcrumb__inner">
                            <span class="breadcrumb__title">Roulette</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div id="user32423"><?=json_encode($player_data)?></div>
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-xl-12" id="box-roulette">
                                    <div class="card">
                                        <div class="init-roulette">
                                            <div class="roulette-main"></div>
                                            <div class="roulette-waiting">
                                                <h5>rolling in</h5>
                                                <h4>loading..</h4>
                                            </div>
                                        </div>
                                        <div id="pointer"></div>
                                        <div class="last-roulette"><!--content--></div>
                                        <div class="form-roulette">
                                            <input type="number" name="r_value" class="input-roulette" placeholder="0">
                                            <center>
                                                <h5 id="your-money">$<?=$player_data->Money?></h5>
                                                <span id="onlines">loading...</span>
                                            </center>
                                        </div>
                                        <div class="roulette-box-center">
                                            <div class="roulette-card" data-bet="1">
                                                <div class="roulette-card-header r_red">
                                                    <span>2x</span>
                                                    <h5>Bet on red</h5>
                                                </div>
                                                <div class="roulette-content">
                                                    <h5 class="header-h5">0 total bet<div class="r_right"><i class="fa fa-money" aria-hidden="true"></i> <span id="r_money-0">0</span></div></h5>
                                                    <hr>
                                                    <div class="roulette-users"></div>
                                                </div>
                                            </div>
                                            <div class="roulette-card" data-bet="2">
                                                <div class="roulette-card-header r_green">
                                                    <span>14x</span>
                                                    <h5>Bet on green</h5>
                                                </div>
                                                <div class="roulette-content">
                                                    <h5 class="header-h5">0 total bet<div class="r_right"><i class="fa fa-money" aria-hidden="true"></i> <span id="r_money-1">0</span></div></h5>
                                                    <hr>
                                                    <div class="roulette-users"></div>
                                                </div>
                                            </div>
                                            <div class="roulette-card" data-bet="0">
                                                <div class="roulette-card-header r_black">
                                                    <span>2x</span>
                                                    <h5>Bet on black</h5>
                                                </div>
                                                <div class="roulette-content">
                                                    <h5 class="header-h5">0 total bet<div class="r_right"><i class="fa fa-money" aria-hidden="true"></i> <span id="r_money-2">0</span></div></h5>
                                                    <hr>
                                                    <div class="roulette-users"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdn.socket.io/3.0.5/socket.io.min.js"></script>
        <script>
            $(document).ready(function() {
                var socket = io('http://localhost:3000', { transports : ['websocket'] });
                var playerData = JSON.parse($('#user32423').html()); $('#user32423').remove();

                socket.on('onlines', (connected) => $('#onlines').html(`${connected} persoane conectate`));
                socket.on('init', (data) => {
                    socket.emit('save-uid', {name:playerData.name,socketid:socket.id});

                    $.each(data.bets, (i, val) => addUser(val));
                    setCollumn(data.roll.pos);
                    lastColor(data.roll.lastColors);

                    if(data.roll.started > 1) {
                        for(let i = 0;i < 3; ++i) {
                            $('.roulette-card-header').eq(i).attr('class', `roulette-card-header r_${color_[slot_color[i]]}-disabled`);
                        }
                    }
                    switch(data.roll.state) {
                        case 0:
                            $('#pointer').hide();
                            $('.roulette-waiting').show();
                            $('.roulette-waiting h4').html(formatTime(data.startIn));
                            break;
                        case 1:
                            $('#pointer').show();
                            $('.roulette-waiting').hide();
                            break;
                        case 2: {
                            let table = r_collumn[data.roll.win];
                            for(let i=0;i<3;++i) {
                                if(i == table) $('.roulette-card').eq(i).addClass('r_win');
                                else $('.roulette-card').eq(i).addClass('r_lose');
                            }
                            break;
                        }
                        case 3: {
                            $('.roulette-users').empty();
                            for(let i=0;i<3;++i) {
                                $('.header-h5').eq(i).html(`
                                    0 total bet<div class="r_right"><i class="fa fa-money" aria-hidden="true"></i> <span id="r_money-${i}">0</span></div>
                                `);
                            }
                            break;
                        }
                    }
                });

                var r_color = [0,0,0,0,0,0,0,0,0,0];
                var r_num = [0,11,5,10,6,9,7,8,1,14,2,13,3,12,4,0];
                var r_color = [2,0,1,0,1,0,1,0,1,0,1,0,1,0,1,2];
                var slot_color = [1,2,0];
                var r_collumn = [2,0,1];

                var color_ = ['black', 'red', 'green'];

                var randomEx = (min,max) => {
                    return (Math.floor(Math.random() * (max-min))+min);
                }

                // aranjeaza ruletta //
                var setPointer = () => {
                    let init = $('#box-roulette').width()/2;
                    $('#pointer').css({right:`${init}px`});
                }

                var setCollumn = (pos) => {
                    let init = (($('.init-roulette').width()/2)-1610) + pos;
                    $('.roulette-main').css({right:`${init}px`});
                }

                // ** end ** //


                var lastColor = (colors) => {
                    $('.last-roulette').empty();
                    $.each(colors, (index, val) => {
                        if(val != -1) $('.last-roulette').append(`<div class="child-roulette r_${color_[r_color[val]]}">${r_num[val]}</div>`);
                        else $('.last-roulette').append(`<div class="child-roulette">?</div>`);
                    });
                }

                // Responsive roulette //
                setPointer(),setCollumn();
                $('.mobile-menu').on('click', () => setTimeout(() => {setPointer(),setCollumn()}, 300));
                $(window).resize(() => {setPointer(),setCollumn()});

                // ** End ** //

                // Roll roulette //

                var formatNumberEx = (number) => {
                    return new Intl.NumberFormat('de-DE').format(number);
                }

                var formatTime = (number) => {
                    return parseFloat(number).toFixed(2);
                }


                var addLastColor = (slot) => {
                    $('.child-roulette').eq(0).remove();
                    $('.last-roulette').append(`<div class="child-roulette r_${color_[r_color[slot]]}">${r_num[slot]}</div>`);

                }


                socket.on('newUser', (data) => addUser(data));

                var addUser = (data) => {
                    if(data.username == playerData.name) {
                        $('.roulette-card-header').eq(data.slot).attr('class', `roulette-card-header r_${color_[slot_color[data.slot]]}-disabled`);
                    }
                    $('.roulette-content .roulette-users').eq(data.slot).prepend(`
                        <div class="roulette-profile">
                            <img src="./assets/avatars/${data.skin}.png" class="img-circle">
                            <p>${data.username}</p>
                            <h5>$${formatNumberEx(data.bet)}</h5>
                        </div>
                    `);
                    $('.header-h5').eq(data.slot).html(
                    `
                    ${data.total} total bet
                    <div class="r_right">
                        <i class="fa fa-money" aria-hidden="true"></i>
                         <span id="r_money-${data.slot}">${data.money}</span>
                    </div>
                    `
                    );

                    $('#your-money').html(`$${playerData.Money}`);

                    animateInt($(`#r_money-${data.slot}`), data.money+data.bet, data.bet);
                }

                var animateInt = (element, target, expl) => {
                    let current = +element.html();
                    const increment = expl / 150;
                    if(current < target) {
                        element.html(`${Math.ceil(current + increment)}`);
                        setTimeout(() => animateInt(element, target, expl), 10);
                    } else {
                        element.html(target);
                    }
                }

                socket.on('update-money', (data) => {
                    if(data.username != playerData.name) return;
                    playerData.Money += data.bet;
                    $('#your-money').html(`$${playerData.Money}`);
                });

                socket.on('change-roulette-event', (data) => {
                    if(data.started > 1) {
                        for(let i = 0;i < 3; ++i) {
                            $('.roulette-card-header').eq(i).attr('class', `roulette-card-header r_${color_[slot_color[i]]}-disabled`);
                        }
                    }
                    switch(data.eventid) {
                        case 0:
                            $('#pointer').hide();
                            $('.roulette-waiting').show();
                            $('.roulette-waiting h4').html(formatTime(data.time));
                            break;
                        case 1:
                            $('#pointer').show();
                            $('.roulette-waiting').hide();
                            break;
                        case 2: {
                            let table = r_collumn[data.win];
                            for(let i=0;i<3;++i) {
                                if(i == table) $('.roulette-card').eq(i).addClass('r_win');
                                else $('.roulette-card').eq(i).addClass('r_lose');
                            }
                            break;
                        }
                        case 3: {
                            $('.roulette-users').empty();
                            for(let i=0;i<3;++i) {
                                $('.roulette-card').eq(i).removeClass('r_win').removeClass('r_lose');
                                $('.roulette-card-header').eq(i).attr('class', `roulette-card-header r_${color_[slot_color[i]]}`);
                                $('.header-h5').eq(i).html(`
                                    0 total bet<div class="r_right"><i class="fa fa-money" aria-hidden="true"></i> <span id="r_money-${i}">0</span></div>
                                `);
                            }
                            break;
                        }
                    }
                });

                socket.on('roulette-event', (data) => {
                    switch(data.eventid) {
                        case 0:
                            $('.roulette-waiting h4').html(formatTime(data.timeout));
                            break;

                        case 1:
                            setCollumn(data.pos);
                            break;

                        case 2:
                            addLastColor(data.slot);
                            break;
                    }
                });

                socket.on('callback_createUser', (data) => {
                    if(!data.exception) return;
                    swal('Eroare!', data.error, 'error');
                });

                $('.roulette-card').on('click', function() {
                    if($('input[name=r_value]').val().length < 1) {
                        swal('Eroare!', 'Introdu numar-ul de pariu pentru a incepe!', 'error');
                        return;
                    }
                    let slot = $(this).index('.roulette-card');
                    let val = parseInt($('input[name=r_value]').val());

                    playerData.Money-=val;

                    socket.emit('createUser', {
                        slot:slot,
                        password: playerData.password,
                        username: playerData.name,
                        skin:playerData.Model,
                        bet:val,
                        color:slot_color[slot]
                    });
                });
            });
        </script>