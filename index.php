<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Bilibili ChatBox</title>
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="bookmark" href="/favicon.ico" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="//www.googletagmanager.com/gtag/js?id=UA-117441173-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-117441173-1');
</script>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-9236201446431167",
    enable_page_level_ads: true
  });
</script>
<!--<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/javascript">
  var bcv;
  var langs = {
    zh: {
      code: "cn",
      text: "繁体中文(CN)"
    },
    jp: {
      code: "jp",
      text: "日本語(JP)"
    },
    en: {
      code: "en",
      text: "English(EN)"
    }
  }
  var defconf = {
    lang: langs.en.code,
    timeformat: "hh:mm:ss",
    displaytime: 20000,
    displaymax: 30,
    colormode: 3,
    noid: false,
    block: {
      lottery: true,
      noregular: false,
      level: 0
    },
    showstatus: true,
    showspanner: true,
    autoreconn: true
  };
  var tipsp = {};
  tipsp[langs.zh.code] = {
      maxlines: "顯示行數上限",
      restime: "單條停留時間",
      showspanner: "以扳手標出房管",
      showstatus: "顯示狀態",
      autoreconn: "自動斷線重連",
      blocklotterydm: "屏蔽抽獎彈幕",
      blockinformalusr: "屏蔽非正式會員",
      blocklevel: "屏蔽用戶 當等級低於",
      colormode: "顯示顏色",
      listenercustom: "按彈幕顏色",
      random: "隨機",
      randomdark: "隨機暗色",
      randomlight: "隨機亮色",
      roomid: "房間號",
      timeftt: "時間顯示格式(留空則不顯示發送時間)",
      connecting: "正在連接房間:",
      connectclosed: "連接中斷",
      reconnecting: "重連中",
      hintmenu: "右擊打開菜單"
    };
  tipsp[langs.jp.code] = {
      maxlines: "表示するコメント数の上限",
      restime: "コメントの表示時間",
      showspanner: "スパナの表示",
      showstatus: "ステータスの表示",
      autoreconn: "自動再接続",
      blocklotterydm: "プレゼントコメントをブロック",
      blockinformalusr: "非正式メンバーをブロック",
      blocklevel: "レベルが右より低いユーザーをブロック",
      colormode: "カラーモード",
      listenercustom: "コメントの色のまま",
      random: "ランダム",
      randomdark: "ランダム暗い色",
      randomlight: "ランダム明るい色",
      roomid: "ルームID",
      timeftt: "時間フォーマット(空欄にすると時間非表示)",
      connecting: "接続中 Room:",
      connectclosed: "接続が切れました",
      reconnecting: "再接続中",
      hintmenu: "右クリックでメニューを開く"
    };
  tipsp[langs.en.code] = {
      maxlines: "Max lines",
      restime: "Residence time(ms)",
      showspanner: "Show spanner",
      showstatus: "Show status & system msg",
      autoreconn: "Auto reconnection",
      blocklotterydm: "Block lottery comment",
      blockinformalusr: "Block informal user",
      blocklevel: "Users with blocking levels below",
      colormode: "Color mode",
      listenercustom: "Listener custom color",
      random: "Random",
      randomdark: "Random dark color",
      randomlight: "Random light color",
      roomid: "Room id",
      timeftt: "Time format(Empty to No display)",
      connecting: "Connecting Room:",
      connectclosed: "Connection closed",
      reconnecting: "Reconnecting",
      hintmenu: "Right click to open the menu"
    };
  var roomdata = <?php echo file_get_contents("https://api.live.bilibili.com/AppRoom/index?platform=android&room_id=".$_GET['roomid']); ?>;
  function getQueryStr(name) {
    var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
    var r = window.location.search.substr(1).match(reg);
    if (r != null)
      return unescape(r[2]);
    return null;
  }
  function getQuerybool(name){
    var d = getQueryStr(name);
    if (d!==null)
      return parseInt(d)!==0;
    return null;
  }
  color = {
    black: "#000000",
    white: "#ffffff"
  }
  function getgrey(c){
    var t=c.length==6?c:c.substr(1);
    var c=t.match(/.{2}/g);
    for (var i=0;i<3;i++){
      c[i] = parseInt(c[i],16);
    }
    return 255-(c[0]*0.299+c[1]*0.587+c[2]*0.144);
  }
  function chkgrey(c){
    var t= getgrey(c);
    return t<144?color.white:color.black;
  }
  function rHex(){
    n = Math.round(Math.random()*255);
    if (n>15) return n.toString(16);
    else return "0"+n.toString(16);
  }
  function rColor(){
    return "#"+rHex()+rHex()+rHex();
  }
  function rLightColor(){
    var c = rColor();
    while (chkgrey(c)==color.black){
      c = rColor();
    }
    return c;
  }
  function rDarkColor(){
    var c = rColor();
    while (chkgrey(c)==color.white){
      c = rColor();
    }
    return c;
  }
  function isFunc(obj){
    return Object.prototype.toString.call(obj)==="[object Function]";
  }
  function isStr(obj){
    return Object.prototype.toString.call(obj)==="[object String]";
  }
  function getUTF8Bytes(str){
  	var bytes = new Array(); 
  	var len,c;
  	len = str.length;
  	for(var i = 0; i < len; i++){
  		c = str.charCodeAt(i);
  		if(c >= 0x010000 && c <= 0x10FFFF){
  			bytes.push(((c >> 18) & 0x07) | 0xF0);
  			bytes.push(((c >> 12) & 0x3F) | 0x80);
  			bytes.push(((c >> 6) & 0x3F) | 0x80);
  			bytes.push((c & 0x3F) | 0x80);
  		}else if(c >= 0x000800 && c <= 0x00FFFF){
  			bytes.push(((c >> 12) & 0x0F) | 0xE0);
  			bytes.push(((c >> 6) & 0x3F) | 0x80);
  			bytes.push((c & 0x3F) | 0x80);
  		}else if(c >= 0x000080 && c <= 0x0007FF){
  			bytes.push(((c >> 6) & 0x1F) | 0xC0);
  			bytes.push((c & 0x3F) | 0x80);
  		}else{
  			bytes.push(c & 0xFF);
  		}
  	}
  	return bytes;
  }
  function getStr(arr) {
    if(typeof arr === 'string') {
      return arr;
    }
    var str = '',
      _arr = arr;
    for(var i = 0; i < _arr.length; i++) {
      var one = _arr[i].toString(2),
        v = one.match(/^1+?(?=0)/);
      if(v && one.length == 8) {
        var bytesLength = v[0].length;
        var store = _arr[i].toString(2).slice(7 - bytesLength);
        for(var st = 1; st < bytesLength; st++) {
          store += _arr[st + i].toString(2).slice(2);
        }
        str += String.fromCharCode(parseInt(store, 2));
        i += bytesLength - 1;
      } else {
        str += String.fromCharCode(_arr[i]);
      }
    }
    return str;
  }
  function dateFtt(fmt,date){
    var o = {
      "M+" : date.getMonth()+1,
      "d+" : date.getDate(),
      "h+" : date.getHours(),
      "m+" : date.getMinutes(),
      "s+" : date.getSeconds(),
      "q+" : Math.floor((date.getMonth()+3)/3),
      "S"  : date.getMilliseconds()
    };
    if(/(y+)/.test(fmt))
      fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
      if(new RegExp("("+ k +")").test(fmt))
    fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    return fmt;
  }
  function gethex(n){
    return n.toString(16);
  }
</script>
</head>
<body>
  <div id="bc-main" v-cloak>
    <div class="bc-wrap">
      <transition-group name="comment-fade" tag="div" class="bcs">
        <div v-for="c in bc" :key="c.id" class="bc" :class="c.uid==roomhost?'livehost':''">
        <span class="bctime" v-if="conf.timeformat!=''" :style="{color: c.color}">[{{c.timeline}}]</span><svg v-if="conf.showspanner && (c.usertype & bchat.usertype.guard)!=0" version="1.1" xmlns="http://www.w3.org/2000/svg" class="spanner-icon" viewBox="0 0 283.5 283.5">
            <path :fill="conf.spannercolor" d="M281.1,60.5c3.3,13.3,3.1,26.7-0.6,40.1c-3.7,13.5-10.5,25.4-20.5,35.7c-11.1,10.7-23.9,17.7-38.5,21
            	c-14.6,3.3-29.1,2.6-43.4-2.2L60.3,273c-7,7-15.4,10.5-25.2,10.5c-9.8,0-18.1-3.4-24.9-10.2C3.4,266.4,0,258.1,0,248.3
            	c0-9.8,3.5-18.2,10.5-25.2l117.9-118.4c-4.8-14-5.5-28.4-2.2-43.2c3.3-14.8,10.3-27.5,21-38.2c10-10,21.8-16.8,35.4-20.5
            	C196.3-0.8,209.7-1,223,2.4c2.6,0.7,4.2,2.3,4.7,4.7c0.6,2.4-0.1,4.5-1.9,6.4l-40.9,41.5l6.1,37.6l37.6,6.1L270,57.7
            	c1.8-1.8,4-2.5,6.4-1.9C278.8,56.3,280.4,57.9,281.1,60.5z M35.4,261.3c3.7,0,6.8-1.3,9.4-3.9c2.6-2.6,3.9-5.7,3.9-9.4
            	c0-3.7-1.3-6.8-3.9-9.4c-2.6-2.6-5.7-3.9-9.4-3.9s-6.8,1.3-9.4,3.9c-2.6,2.6-3.9,5.7-3.9,9.4c0,3.7,1.3,6.8,3.9,9.4
            	C28.6,260,31.7,261.3,35.4,261.3z"/>
          </svg><b><span class="bccolor" :style="{color: c.color}"><span class="bcuser" :style="conf.noid?'display:none;':''">{{c.nickname}}: </span><span class="bctext">{{c.text}}</span></span></b>
        </div>
      </transition-group>
    </div>
    <transition name="confmenu">
      <div id="menu" :class="showmenu?'show':'hide'">
        <div class="menu-mask" key="menumask" @click="showmenu=false"></div>
        <div class="menu-wrap" key="menuwrap">
          <div><label>{{tips.maxlines}}</label><input type="text" v-model="conf.displaymax" pattern="[0-9]" min="1" max="99" maxlength="2" /></div>
          <div><label>{{tips.restime}}</label><input type="text" v-model="conf.displaytime" pattern="[0-9]" min="1" max="999999999" maxlength="9" /></div>
          <div><label for="showspanner">{{tips.showspanner}}</label><input type="checkbox" id="showspanner" v-model="conf.showspanner" /></div>
          <div><label for="showstatus">{{tips.showstatus}}</label><input type="checkbox" id="showstatus" v-model="conf.showstatus" /></div>
          <div><label for="autoreconnect">{{tips.autoreconn}}</label><input type="checkbox" id="autoreconnect" v-model="conf.autoreconn" /></div>
          <div><label for="blocklotterydm">{{tips.blocklotterydm}}</label><input type="checkbox" id="blocklotterydm" v-model="conf.block.lottery" /></div>
          <div><label for="blockinformalusr">{{tips.blockinformalusr}}</label><input type="checkbox" id="blockinformalusr" v-model="conf.block.noregular" /></div>
          <div class="blocklevel">
            <label>{{tips.blocklevel}}</label><input type="text" v-model="conf.block.level" pattern="[0-9]" min="0" max="99" maxlength="2" />
            <br />
            <input type="range" v-model="conf.block.level" min="0" max="20" />
          </div>
          <div class="colormode">
            <label>{{tips.colormode}}</label>
            <transition name="colormodets">
              <button :key="'colormode'+conf.colormode" @click="switchcolormode">{{colormodestr}}</button>
            </transition>
          </div>
          <div class="roomid">
            <label>{{tips.roomid}}</label>
            <input type="text" v-model="roomid" pattern="[0-9]" min="1" max="99" maxlength="9" />
          </div>
          <div class="timeftt">
            <label>{{tips.timeftt}}</label><br />
            <input type="text" v-model="conf.timeformat" />
          </div>
          <button key="applyconfbtn" @click="applyconf">OK</button>
          <a id="about" target="_blank" href="https://github.com/SakuranoKuriko/bilibili-chatbox">Source code</a>
          <select class="langsel" v-model="conf.lang">
            <option v-for="l in langs" :value="l.code">{{l.text}}</option>
          </select>
        </div>
      </div>
    </transition>
  </div>
  <script type="text/javascript">
  var bb = {
    debug: false,
    read: function(blobdata, cb, asText = false){
      var r = new FileReader();
      r.onloadend = function(){
        if (isFunc(cb))
          cb.call(r, r.result);
      }
      if (asText) r.readAsText(blobdata);
      else r.readAsArrayBuffer(blobdata);
    },
    mkbuf: function(pobj){
      var data = [];
      if (pobj.data!==undefined)
        data = getUTF8Bytes(JSON.stringify(pobj.data));
      var pbuf = new ArrayBuffer(16+data.length);
      var dv = new DataView(pbuf);
      dv.setUint32(0, pbuf.byteLength);
      dv.setUint16(4, 16);
      dv.setUint16(6, 1);
      dv.setUint32(8, pobj.type);
      dv.setUint32(12, 1);
      var u = new Uint8Array(pbuf, 16);
      for (var i=0;i<data.length;i++){
        u[i] = data[i];
      }
      return pbuf;
    },
    mkblob: function(pobj){
      return new Blob([this.mkbuf(pobj)]);
    },
    un: function(pbuf, cb){
      if (!isFunc(cb))
        return;
      var dv = new DataView(pbuf, 0, 16);
      var obj =  {
        size: dv.getUint32(0),
        headsize: dv.getUint16(4),
        version: dv.getUint16(6),
        type: dv.getUint32(8),
        sequence: dv.getUint32(12)
      };
      this.read(new Blob([pbuf.slice(16, obj.size)]), (t)=>{
        obj.data = t;
        var tobj = obj;
        setTimeout(()=>{cb(tobj);},1);
      }, true);
      if (obj.size<pbuf.byteLength)
        this.un(pbuf.slice(obj.size), cb);
      else bchat.delays = 1;
    }
  }
  var bchat = {
    debug: false,
    ws: null,
    hbtimer: null,
    hbtime: 30000,
    usrid: 0,
    delays: 1,
    protover: 1,
    platform: "web",
    clientver: "1.4.0",
    server: getQueryStr("server") || "wss://broadcastlv.chat.bilibili.com:2245/sub",
    ptype: {
      clienthb: 2, //客户端发送的心跳包
      popularity: 3, //人气值，数据不是JSON字符串而是INT
      command: 5, //命令
      sign: 7, //认证
      serverhb: 8 //服务端发送的心跳包
    },
    cmd: {
      dm: "DANMU_MSG", //收到弹幕
      dm2: "DANMU_MSG:4:0:2:2:2:0", //190529 新弹幕指令
      //dmex: /^DANMU_MSG[0-9:]{0,16}$/, //弹幕指令正则
      dmex: /^DANMU_MSG/i, //弹幕指令正则
      gift: "SEND_GIFT", //有人送礼
      welcome: "WELCOME", //欢迎加入房间
      welcomeguard: "WELCOME_GUARD", //欢迎房管加入房间
      sys: "SYS_MSG", //系统消息
      livestop: "PREPARING", //主播准备中
      livestart: "LIVE" //直播开始
      /*
        # 前端扒到的
        '66FFFF', 'SYS_MSG', 'SYS_GIFT', 'GUARD_MSG', 'SEND_GIFT', 'LIVE',
        'PREPARING', 'END', 'CLOSE', 'BLOCK', 'ROUND', 'WELCOME', 'REFRESH',
        'ACTIVITY_RED_PACKET', 'ROOM_LIMIT', 'PK_PRE', 'PK_END', 'PK_SETTLE',
        'PK_MIC_END', 'live', 'preparing', 'end', 'close', 'block', 'pre-round',
        'round', 'error', 'player-state-play', 'player-state-pause', 'http:',
        'https:', 'ws:', 'wss:', 'videoVolume', 'homeVideoVolume', 'div',
        'canvas', 'initialized', 'playerStateChange', 'liveStateChange',
        'videoStateChange', 'fullscreenChange', 'playing', 'paused', 'switchLine',
        'switchQuality', 'webFullscreen', 'feedBackClick', 'blockSettingClick',
        'set', 'initDanmaku', 'addDanmaku', 'sendDanmaku', 'receiveOnlineCount',
        'receiveMessage', 'userLogin', 'giftPackageClick', 'sendGift', 'guidChange',
        'reload', 'danmaku', 'block', 'gift', 'firstLoadedAPIPlayer',
        'firstLoadedAPIPlayurl', 'firstLoadStart', 'firstLoadedMetaData',
        'firstPlaying', 'enterTheRoom', 'operableElementsChange',
        # 其他遇到的
        'COMBO_SEND', 'COMBO_END', 'ROOM_RANK', 'NOTICE_MSG', 'WELCOME_GUARD',
        'WISH_BOTTLE', 'RAFFLE_START', 'ENTRY_EFFECT'
      */
    },
    state: {
      connecting: 0,
      open: 1,
      closing: 2,
      closed: 3
    },
    dmtype: { //弹幕类型
      normal: 0, //非抽奖弹幕
      lottery: 2 //抽奖弹幕
    },
    fleettype: { //舰队身份类型
      normal: 0, //非舰长
      governor: 1, //总督
      praefect: 2, //提督
      captain: 3, //舰长
    },
    usertype: { //用户类型
      auth: 1, //已验证手机
      regular: 2, //正式会员
      guard: 4, //房管
      vip: 8, //老爷
      svip: 16, //年费老爷
    },
    unpackdm: function(infoobj){
      var p = {
        comment: {
          color: "#"+gethex(infoobj[0][3]), //弹幕颜色
          time: new Date((infoobj[0][4] || infoobj[9].ts)*1000), //发送时间
          type: infoobj[0][9], //弹幕类型
          fleettype: infoobj[0][10] || infoobj[7], //舰队身份类型
          text: infoobj[1] //弹幕内容
        },
        user: {
          uid: infoobj[2][0], //发送者UID
          uidstr: infoobj[2][0].toString(), //发送者UID
          name: infoobj[2][1], //发送者昵称
          type: 0, //用户身份
          color: infoobj[2][7], //用户名颜色
          badge: { //粉丝勋章
            level: infoobj[3][0], //等级
            name: infoobj[3][1], //名称
            msg: infoobj[3][2], //说明信息
            roomid: infoobj[3][3], //勋章主播的房间号
          },
          level: { //用户等级
            level: infoobj[4][0], //等级
            color: infoobj[4][2], //等级颜色
            rank: infoobj[4][3], //排名字符串
          },
          title: infoobj[5] //活动头衔
        }
      };
      if (infoobj[2][2]==1) p.user.type = p.user.type | this.usertype.guard;
      if (infoobj[2][3]==1) p.user.type = p.user.type | this.usertype.vip;
      if (infoobj[2][4]==1) p.user.type = p.user.type | this.usertype.svip;
      if (infoobj[2][5]==10000) p.user.type = p.user.type | this.usertype.regular;
      if (infoobj[2][6]==1) p.user.type = p.user.type | this.usertype.auth;
      return p;
    },
    conn: function(roomid, roomhost = -1){
      if (this.ws !== null && this.ws.readyState == this.state.open)
        this.close();
      bcv.roomid = roomid;
      bcv.roomhost = roomhost;
      bcv.bcmsg(bcv.tips.connecting+bcv.roomid);
      this.ws = new WebSocket(this.server);
      this.ws.binaryType = "arraybuffer"
      this.ws.onopen = () => {
        if (this.hbtimer !== null)
          clearInterval(this.hbtimer);
        this.hbtimer = setInterval(this.hb, this.hbtime);
        this.send(bb.mkblob({type: this.ptype.sign, data: {
            uid: this.usrid, //表示未登录，否则为用户ID
            roomid: roomid, //房间ID
            protover: this.protover, //协议版本
            platform: this.platform, //平台
            clientver: this.clientver //客户端版本
        }}));
        if (this.debug)
          console.log("WebSocket: Open");
      }
      this.ws.onmessage = (ev) => {
        if (!isStr(ev))
          bb.un(ev.data, (d) => { //一次可能收到多个包，回调执行多次
            if (this.debug)
              console.log(JSON.stringify(d));
            if (d.type!= this.ptype.command)
              return;
            var p = JSON.parse(d.data);
            //if (p.cmd!=this.cmd.dm&&p.cmd!=this.cmd.dm2)
            if (!this.cmd.dmex.test(p.cmd))
              return;
            var dm = this.unpackdm(p.info);
            if (bcv.conf.block.lottery && dm.comment.type == this.dmtype.lottery)
              return; //屏蔽抽奖弹幕
            if (bcv.conf.block.noregular && dm.user.type & this.usertype.regular==0)
              return; //屏蔽非正式会员
            if (bcv.conf.block.level>dm.user.level.level)
              return; //屏蔽等级不足用户
            setTimeout(() => {
              bcv.bcpush(dm);
            }, (bchat.delays++)<<8);
          });
      }
      this.ws.onclose = (ev) => {
        if (this.hbtimer === null)
          return;
        clearInterval(this.hbtimer);
        this.hbtimer = null;
        if (this.debug)
          console.log("WebSocket: Closed");
        bcv.bcmsg(bcv.tips.connectclosed);
        if (bcv.conf.autoreconn){
          bcv.bcmsg(bcv.tips.reconnecting);
          this.conn(bcv.roomid);
        }
      }
    },
    send: function(d){
      this.ws.send(d);
    },
    hb: function(){
      bchat.send(bb.mkblob({type: bchat.ptype.clienthb, data: ""}));
      if (bchat.debug)
        console.log("WebSocket: Client heart beat");
    },
    close: function(){
      if (this.ws.readyState == this.state.closing || this.ws.readyState == this.state.closed)
        return;
      this.ws.close();
    }
  }
  bcv = new Vue({
    el: "#bc-main",
    data: {
      bc: [],
      roomid: 0,
      roomhost: -1,
      tips: {},
      conf: {
        lang: getQueryStr("la") || defconf.lang,
        spannercolor: "#4444ff",
        timeformat: getQueryStr("tf")!==null?getQueryStr("tf"):defconf.timeformat,
        displaytime: parseInt(getQueryStr("t")) || defconf.displaytime,
        displaymax: parseInt(getQueryStr("l")) || defconf.displaymax,
        colormode: getQueryStr("c")!==null?parseInt(getQueryStr("c")):defconf.colormode,
        noid: getQuerybool("noid")!==null?getQuerybool("noid"):defconf.noid,
        whitelist: getQueryStr("whitelist")!==null?getQueryStr("whitelist").replace(/[^\d,]/gm,'').split(','):[],
        blacklist: getQueryStr("blacklist")!==null?getQueryStr("blacklist").replace(/[^\d,]/gm,'').split(','):[],
        block: {
          lottery: getQuerybool("nl")!==null?getQuerybool("nl"):defconf.block.lottery, //屏蔽抽奖弹幕
          noregular: getQuerybool("nr")!==null?getQuerybool("nr"):defconf.block.noregular, //屏蔽非正式会员
          level: parseInt(getQueryStr("lv")) || defconf.block.level //屏蔽等级不足用户
        },
        showstatus: getQuerybool("st")!==null?getQuerybool("st"):defconf.showstatus,
        showspanner: getQuerybool("sp")!==null?getQuerybool("sp"):defconf.showspanner,
        autoreconn: getQuerybool("re")!==null?getQuerybool("re"):defconf.autoreconn,
        colormodes: {
          bccolor: 0,
          random: 1,
          randomdark: 2,
          randomlight: 3
        },
      },
      showmenu: false,
      bccount: 0
    },
    computed: {
      colormodestr: function(){
        switch(this.conf.colormode){
          case this.conf.colormodes.bccolor:
            return this.tips.listenercustom;
          case this.conf.colormodes.random:
            return this.tips.random;
          case this.conf.colormodes.randomdark:
            return this.tips.randomdark;
          case this.conf.colormodes.randomlight:
            return this.tips.randomlight;
        }
      },
      lang: function(){
        return this.conf.lang;
      }
    },
    watch: {
      lang: function(){
        this.loadlang();
      }
    },
    methods: {
      loadlang: function(){
        this.tips = Object.assign({}, this.tips, tipsp[this.conf.lang]);
      },
      bcpush: function(bcobj){
        if (this.conf.whitelist.length>0){
          if (this.conf.whitelist.indexOf(bcobj.user.uidstr)==-1)
            return;
        }
        else if (this.conf.blacklist.length>0)
          if (this.conf.blacklist.indexOf(bcobj.user.uidstr)!=-1)
            return;
        var c = {
          text: bcobj.comment.text,
          uid: bcobj.user.uid,
          nickname: bcobj.user.name,
          usertype: bcobj.user.type,
          color: "#000",
          timeline: this.conf.timeformat!=""?dateFtt(this.conf.timeformat, new Date(bcobj.comment.time)):"",
          time: bcobj.comment.time,
          id: "bc"+this.bccount++
        };
        if (c.uid!=this.roomhost){
          switch (this.conf.colormode){
            case this.conf.colormodes.bccolor:
              c.color = bcobj.comment.color;
              break;
            case this.conf.colormodes.random:
              c.color = rColor();
              break;
            case this.conf.colormodes.randomdark:
              c.color = rDarkColor();
              break;
            default:
              c.color = rLightColor();
          }
        }
        this.bc.push(c);
        this.$forceUpdate();
        if (this.bc.length<=this.conf.displaymax)
          return this.bcshift();
        this.bcshift(1);
        return -1;
      },
      bcmsg: function(msg){
        if (!this.conf.showstatus)
          return;
        var t = this.conf.timeformat!=""?dateFtt(this.conf.timeformat, new Date()):"";
        this.bc.push({
          text: msg,
          nickname: "<System>",
          timeline: t,
          color: "#ff0000",
          id: "sys"+this.bccount++
        })
        console.info("["+t+"]"+msg);
        return this.bcshift();
      },
      bcshift: function(t){
        var to = t!=undefined?t:this.conf.displaytime;
        return setTimeout(() => { bcv.bc.shift(); }, to);
      },
      applyconf: function(){
        newurl = location.pathname+"?roomid="+this.roomid;
        if (this.conf.displaytime != defconf.displaytime)
          newurl += "&t="+this.conf.displaytime;
        if (this.conf.displaymax != defconf.displaymax)
          newurl += "&l="+this.conf.displaymax;
        if (this.conf.colormode != defconf.colormode)
          newurl += "&c="+this.conf.colormode;
        if (this.conf.block.lottery != defconf.block.lottery)
          newurl += "&nl="+(this.conf.block.lottery?1:0);
        if (this.conf.block.noregular != defconf.block.noregular)
          newurl += "&nr="+(this.conf.block.noregular?1:0);
        if (this.conf.block.level != defconf.block.level)
          newurl += "&lv="+this.conf.block.level;
        if (this.conf.showstatus != defconf.showstatus)
          newurl += "&st="+(this.conf.showstatus?1:0);
        if (this.conf.showspanner != defconf.showspanner)
          newurl += "&sp="+(this.conf.showspanner?1:0);
        if (this.conf.autoreconn != defconf.autoreconn)
          newurl += "&re="+(this.conf.autoreconn?1:0);
        if (this.conf.timeformat != defconf.timeformat)
          newurl += "&tf="+escape(this.conf.timeformat);
        if (this.conf.lang != defconf.lang)
          newurl += "&la="+this.conf.lang;
        if (this.conf.noid != defconf.noid)
          newurl += "&noid="+(this.conf.noid?1:0);
        if (this.conf.whitelist.length>0)
          newurl += "&whitelist=" + this.conf.whitelist.join(',');
        if (this.conf.blacklist.length>0)
          newurl += "&blacklist=" + this.conf.blacklist.join(',');
        location.href = newurl;
      },
      switchcolormode: function(){
        this.conf.colormode = ++this.conf.colormode%Object.keys(this.conf.colormodes).length;
      }
    }
  });

  window.oncontextmenu=function(e){
    if (!bcv.showmenu){
      e.preventDefault();
      bcv.showmenu = true;
    }
  }

  bcv.loadlang();
  bcv.bcmsg(bcv.tips.hintmenu);
  if (roomdata.code==0)
    bchat.conn(roomdata.data.room_id, roomdata.data.mid);
  else
    if (roomdata.code==-614) bchat.conn(parseInt(getQueryStr("roomid")));
    else bcv.bcmsg("Error["+roomdata.code+"]: "+roomdata.message);
  </script>
</body>
<!-- WebSocket
wss://broadcastlv.chat.bilibili.com:2245/sub

封包格式：
头：
偏移	长度	含义
0	4	封包总大小
4	2	头部长度
6	2	协议版本，目前是1
8	4	操作码（封包类型）
12	4	sequence，可以取常数1
操作码：
2	客户端发送的心跳包
3	人气值，数据不是JSON，是4字节整数
5	命令，数据中['cmd']表示具体命令
7	认证并加入房间
8	服务器发送的心跳包

数据格式：一般为JSON字符串UTF-8编码

心跳包：客户端要每30s发一次

命令包：
根据前端代码，数据也可能是多条命令的数组，不过我只收到过单条命令。每条命令中['cmd']表示具体命令
已知的命令：
命令	含义
DANMU_MSG	收到弹幕
DANMU_MSG:4:0:2:2:2:0 190529新弹幕指令
SEND_GIFT	有人送礼
WELCOME	欢迎加入房间
WELCOME_GUARD	欢迎房管加入房间
SYS_MSG	系统消息
PREPARING	主播准备中
LIVE	直播开始
WISH_BOTTLE	许愿瓶？

//弹幕数据
{
	"cmd": "DANMU_MSG", //命令为弹幕消息
	"info": [ //数据
		[
			0,
			1,
			25,
			14893055, //弹幕颜色
			1552064066, //发送时间
			1552058014,
			0,
			"b095da00",
			0,
			0, //0=普通弹幕，2=抽奖弹幕
			0 //2=提督?
		],
		"哼~╭(╯^╰)╮就我最粗", //弹幕内容
    [ //发送者
			822037, //UID
			"鱿鱼猫", //昵称
			1, //房管
			1, //老爷
			1, //年费老爷
			10000, //10000=正式用户，5000=非正式会员用户
			1, //已绑定手机？
			"#ffffff" //用户名颜色
		],
		[ //发送者的勋章
      10, //勋章等级
      "咕咕醒", //勋章名称
      "还有醒着的么", //勋章说明
      56237, //勋章主播的直播间房间号
      10512625,
      ""
    ],
		[ //发送者用户等级
			31, //用户等级
			0,
			10512625, //用户等级颜色
			"\u003e50000" //用户排名
		],
    [ //活动头衔
      "title-134-1",
      "title-134-1"
    ],
		0,
		3, //0=普通用户，3=舰长，2=提督，1=总督?
		null,
		{
			"ts": 1552064066, //发送时间
			"ct": "BD5DD746"
		}
	]
}
-->
<!-- API
获取房间信息
https://api.live.bilibili.com/room/v1/Room/room_init?id=387
id：房间ID
返回：JSON
{
  "code": 0, //响应代码
  "msg": "ok", //响应信息
  "message": "ok", //响应信息
  "data":{
    "room_id": 280446, //房间真实ID
    "short_id": 387, //房间短ID
    "uid": 8192168, //主播UID
    "need_p2p": 0,
    "is_hidden": false,
    "is_locked": false,
    "is_portrait": false,
    "live_status": 1, //是否直播中，0或1
    "hidden_till": 0,
    "lock_till": 0,
    "encrypted": false,
    "pwd_verified": false,
    "live_time": 1551827238, //直播开始时间
    "room_shield": 0,
    "is_sp": 0,
    "special_type": 0
  }
}

获取评论数据
https://api.live.bilibili.com/ajax/msg?roomid=280446&token=&csrf_token=1a019a40374c7d792be7ef2c696c07fc
roomid：房间真实ID
token：未知
csrf_token：必须
返回：JSON
{
  "code": 0, //响应代码
  "msg": "", //响应信息
  "message": "", //响应信息
  "data": {
    "admin": [{ //管理员评论，10条
      "text": "哈哈哈哈哈哈哈哈哈哈h哈哈哈哈哈", //评论内容
      "nickname": "珏弟求生", //发送者昵称
      "uname_color": "",
      "uid": 3802303, //发送者UID
      "timeline": "2019-03-06 10:00:47", //发送时间
      "isadmin": 1, //是否是管理员
      "vip": 0,
      "svip": 0,
      "medal": [ //观众勋章
        19, //勋章等级
        "卿言", //勋章名称
        "叶落莫言", //勋章主播名称
        280446,
        16752445,
        "union"
      ],
      "title": ["title-144-2", "title-144-2"],
      "user_level": [ //观众等级
        44, //观众等级
        0,
        16746162,
        9352 //观众排名
      ],
      "rank": 10000,
      "teamid": 0,
      "rnd": "1551827169",
      "user_title": "title-144-2",
      "guard_level": 3,
      "bubble": 0,
      "check_info": {
        "ts": 1551837647,
        "ct": "352D4F10"
      }
    }],
    "room": [] //普通观众评论，详细同管理员评论，10条
  }
}
-->
</html>
