var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res) {
  res.sendfile('/files/pages/ruleta.crack.php', { root: __dirname + '/..' });
});

var mysql = require('mysql');

var con = mysql.createConnection({
  host: '127.0.0.1',
  user: 'root',
  password: '',
  database: 'b-hood'
});

con.connect(function(err) {
  if (err) throw err;
  console.log("[MYSQL] Baza de date s-a conectat cu success!");
});


http.listen(3000, function(){
  
  console.log('[SYSTEM] server is online! port: 3000');
});

const ROLL_START_IN = 20.00;

var r_color = [2,0,1,0,1,0,1,0,1,0,1,0,1,0,1,2];



var connected = 0;

var color_ = ['black', 'red', 'green'];

var stockBets = [];

var rollInfo = {
  "timeout": 0,
  "state": 0,
  "pos": 35,
  "time": 0,
  "started":0,
  "lastColors":[-1,-1,-1,-1,-1,-1,-1,-1,-1,-1],
  "total":[0,0,0],
  "money":[0,0,0],
  "win":0
};

var random = (min,max) => {
    return (Math.floor(Math.random() * (max-  min)) + min);
}

var procent = (num1,num2) => {
  return Math.floor((num1*100)/num2);
}

io.on("connect", (data) => {
  console.log(`[SYSTEM] O persoana s-a conectat in system. (${data.id})`); // true
});

io.on('connection', function(socket) {

  socket.on('createUser', (data) => {
    if(rollInfo.started > 1) {
      socket.emit('callback_createUser', {exception:true,error:'Asteapta pana la urmatoarea rotire!'});
      return;
    }

    for(var i in stockBets) {
      if(data.username == stockBets[i].username && data.color == stockBets[i].color) {
        socket.emit('callback_createUser', {exception:true,error:'Ai pariat deja pe aceasta culoare!'});
        return;
      }
    }

    con.query('SELECT `Money` FROM `users` WHERE `name` = ? AND `password` = ? AND `Money` >= ? LIMIT 1', [data.username, data.password, data.bet], (err,result) => {
      if(err) throw err;
      if(!result.length) {
        socket.emit('callback_createUser', {exception:true,error:'Nu ai suficienti banii!'});
        return;
      }
      else {
        rollInfo.total[data.slot]++;

        var for_user = {
          slot:data.slot,
          password:data.password,
          username:data.username,
          skin:data.skin,
          bet:data.bet,
          color:data.color,
          total:rollInfo.total[data.slot],
          money:rollInfo.money[data.slot]
        }

        socket.broadcast.emit('newUser', for_user);
        socket.emit('newUser', for_user);
        stockBets.push(for_user);

        con.query('UPDATE `users` SET `Money` = `Money` - ? WHERE `name` = ? AND `password` = ?', [data.bet, data.username, data.password], function(err, result) {
          if(err) throw err;
          console.log(`[MYSQL] Banii lui ${data.username} au fost luati!`);
        });

        rollInfo.money[data.slot] += data.bet;
        console.log(`[SYSTEM] ${data.username} a pariat suma de $${data.bet} pe culoarea ${color_[data.color]}`);
        startRoulette(socket);
      }
    });
  });

  connected++;
  socket.broadcast.emit("onlines", connected);
  socket.emit("onlines", connected);

  socket.emit('init', {bets:stockBets, roll:rollInfo, startIn:ROLL_START_IN});


  socket.on("disconnect", (reason) => {
    console.log(`[SYSTEM] O persoana s-a deonctat. (${socket.id})`);
    connected--;
    socket.broadcast.emit("onlines", connected);
  });
});

function startRoulette(socket) {
  if(rollInfo.started) return true;
  rollInfo.started = 1;
  var rolling = () => {
    rollInfo.pos += procent(rollInfo.time, rollInfo.timeout) / 2;
    rollInfo.time -= (procent(rollInfo.time, rollInfo.timeout) / 2) + 2;
    if(rollInfo.pos >= 1085) rollInfo.pos = 35;
    sendRouletteEvent(socket,{eventid:1,pos:rollInfo.pos});

    if(rollInfo.time>0) setTimeout(rolling, 10);
    else {
      let slot = Math.floor(rollInfo.pos / 70);
      sendRouletteEvent(socket,{eventid:2,slot:slot});
      rollInfo.state = 2;
      sendToAllUsers(socket, 'change-roulette-event', {eventid:2,time:ROLL_START_IN,win:r_color[slot],started:2});
      rollInfo.win = r_color[slot];

      for(let i = 1;i < 10;++i) rollInfo.lastColors[i-1] = rollInfo.lastColors[i];
      rollInfo.lastColors[9] = slot;

      var win_money = 0;
      for(let x in stockBets) {
        win_money = 0;
        if(stockBets[x].color == r_color[slot]) {
          con.query('UPDATE `users` SET `Money` = `Money` + ? WHERE `name` = ? AND `password` = ?', [(r_color[slot] != 2 ? (stockBets[x].bet * 2) : (stockBets[x].bet * 14)), stockBets[x].username, stockBets[x].password], function(err, result) {
            if(err) throw err;
            console.log(`[MYSQL] datele lui ${stockBets[x].username} au fost salavate cu success!`);
            sendToAllUsers(socket,'update-money', {username:stockBets[x].username,bet:(r_color[slot] != 2 ? (stockBets[x].bet * 2) : (stockBets[x].bet * 14))});
          });
        }
      }

      setTimeout(() => {
        sendToAllUsers(socket, 'change-roulette-event', {eventid:3,time:ROLL_START_IN,started:2});
        rollInfo.state = 3;
        setTimeout(() => {
            sendToAllUsers(socket, 'change-roulette-event', {eventid:0,time:ROLL_START_IN,started:0});
            rollInfo.state = 0;
            rollInfo.started = 0;
            rollInfo.win = 0;

            rollInfo.time = 0;
            rollInfo.timeout = 0;

            stockBets = [];
            rollInfo.total = [0,0,0];
            rollInfo.money = [0,0,0];
        }, 1000);
      }, 3000);
    }
  }

  var roll_in = () => {
    rollInfo.timeout -= 0.015;
    sendRouletteEvent(socket,{eventid:0,timeout:rollInfo.timeout});
    if(rollInfo.timeout > 0) setTimeout(roll_in, 10);
    else {
      rollInfo.timeout = rollInfo.time = random(50 * 70, 150 * 70);
      rollInfo.started = 2;
      rolling();
      sendToAllUsers(socket, 'change-roulette-event', {eventid:1,started:2});
    }
  }
  rollInfo.timeout = ROLL_START_IN;
  roll_in();
  sendToAllUsers(socket, 'change-roulette-event', {eventid:0,started:1});
}

function sendRouletteEvent(socket,data) {
  sendToAllUsers(socket,'roulette-event', data);
  rollInfo.state = data.eventid;
} 

function sendToAllUsers(socket,callback,data) {
  socket.broadcast.emit(callback,data);
  socket.emit(callback,data);
}