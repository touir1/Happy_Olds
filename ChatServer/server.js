'user strict';

var config = {
	serverUrl: 'http://127.0.0.1',
	serverPort: 8000,
	users: [],
};

var //sql = require('./db.js'),
	request = require('request'),
	_ = require('lodash'),
	express = require('express'),
	app = express(),
	port = process.env.PORT || 3000,
	bodyParser = require('body-parser'),
	server = require('http').createServer(app),
	io = require('socket.io')(server,{
		handlePreflightRequest: (req, res) => {
			const headers = {
				"Access-Control-Allow-Headers": "Content-Type, Authorization",
				"Access-Control-Allow-Origin": req.headers.origin, //or the specific origin you want to give access to,
				"Access-Control-Allow-Credentials": true
			};
			res.writeHead(200, headers);
			res.end();
		}
	});

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

server.listen(port, () => {
	console.log('Server listening at port %d', port);

    updateUserList();
	setInterval(updateUserList,30000);
});

io.on('connection', function (socket) {

	socket.on('message', function(data){

		handleMessage(socket, data.message, data.user, data.group);
	});

	socket.on('subscribe',function(data){

		handleSubscription(socket, data.user, data.groups);
	});
});

function handleMessage(socket,msg,idUser,idGroup){

	console.log('message['+idGroup+'] from '+idUser+': '+msg);

	io.sockets.in(idGroup).emit('messages', {
		message: msg,
		group: idGroup,
		user: _.findLast(config.users,function(el){
			return el.id == idUser;
		}),
	});
}

function handleSubscription(socket,user,groupList){
	console.log('subscrioption handler:');
	console.log(user);
	console.log(groupList);

	for(let group of groupList) {
		socket.join(group);
	}

}

function  updateUserList(){
    request.get(config.serverUrl + ':'+config.serverPort+'/api/entertainment/chatRoom/users/list', { json: true }, (err, res, body) => {
        if (err) { return console.log(err); }
        //console.log(body.url);
        config.users = body;
        //console.log(body.explanation);
    });
}




