// Utility for older browsers
if (typeof Object.create !== 'function') {
    Object.create = function (obj) {
        function F() {};
        F.prototype = obj;
        return new F();
    };
}

	var InstaBaloon = {
			id:0,
			mapobj:null,
			instaobj:null,
			life:20*60, // 10 ����� ����� �� ����� �����			
			speed:0.00001, /*deprecated �������� ��������*/
			instamap:null,
			bornat:0,
			
			/*fly: function() {
				var self = this;
				
				self.life--;
				
				
					setTimeout(function(){
				
						if (self.life>0)
							{
							coords = self.mapobj.geometry.getCoordinates();					
							var lat = coords[0];
							var long = coords[1];
							
							self.mapobj.geometry.setCoordinates([lat+self.speed, long]);
							}
							
					
						self.fly();
							
					}, 500);
				
					//console.log(this.life, Math.round(+new Date()/1000)-this.instaobj.created_time, self.instamap.runInterval*5);
				if(this.life<-500 && (Math.round(+new Date()/1000)-this.instaobj.created_time > self.instamap.runInterval*5))
					this.die();
				
			},*/
			die:function() {

                var self = this;

				if (this.instamap.cluster != null)					
					this.instamap.cluster.remove(this.mapobj);

                if (this.instamap.map != null) {
                    this.instamap.map.geoObjects.each(function(obj){
                        if (obj == self.mapobj) {
                            self.instamap.map.geoObjects.remove(obj);
                        }
                    });
                }

				/*if (this.mapobj.getMap() != null && this.mapobj.getMap() != undefined)
					this.mapobj.getMap().remove(this.mapobj);*/

				delete this.instamap.balloons[this.instamap.balloons.indexOf(this)];	
				
			}
	}

	var	Instamap = {
			
			accessToken:'',
			insta_url:'https://api.instagram.com/v1',			
			map:null,
			options:{},
			balloons:new Array(),
			uniqUsers:new Array(),
			km1: 0.012290954,
			runTimes:50,
			runInterval:25,
			cluster:null,
            scanTime:15*60,
			
			init: function (map, photo_div, options) {				
				this.map=map;
				this.options = options;
                var self = this;

                $('#periodSelect').change(function() {
                      self.updateRefreshPeriod();
                    });

                map.events.add('actionend', function (e) {
                   self.scanMap();
                });
			},

            updateRefreshPeriod: function () {
                var value=$('#periodSelect').val(),
                    tm=0;

              switch (value) {
                  case '15m': tm = 15 * 60; break;
                  case '30m': tm = 30 * 60; break;
                  case '1h':  tm = 60 * 60; break;
                  case '6h':  tm = 6 * 60 * 60; break;
                  case '24h': tm = 24 * 60 * 60; break;
                  case '6d': tm =  6 * 24 * 60 * 60; break;
              }

               this.scanTime = tm;

               this.scanMap();

            },
	
			fetch: function (getData) {
		            var self = this,
		                getUrl = self.insta_url + getData;

		            return $.ajax({
		                type: "GET",
		                dataType: "jsonp",
		                cache: false,
		                url: getUrl
		            });
		        },
			
						
			placePhotos: function(list) {
				
				var caption = '',
					self = this;
				
				list.data.forEach(function(element, index) {

					caption='';
					if (element.caption!=null)
						caption = element.caption.text; 					
									
					var len =  self.balloons.length;
					
					// ��������� �� �������			
					for (var i = 0; i < len; i++) {
						//console.log('for', self.balloons[i].instaobj.id);						
						if (element.id == self.balloons[i].instaobj.id) 						
							return;							
					};
					
					//������� �������
					if (self.cluster == null)
						{
						self.cluster = new ymaps.Clusterer({minClusterSize:6, preset: 'twirl#yellowClusterIcons'});
						self.map.geoObjects.add(self.cluster);
						console.log(self.cluster);
						}
					
					// ��������� ����� �� �����
					var balloon = new ymaps.Placemark([element.location.latitude, element.location.longitude], {			            
						balloonContentHeader: caption,
			            balloonContentBody: '<a target="_blank" href="'+element.link+'"><img src="'+element.images.thumbnail.url+'"/></a>',
			            balloonContentFooter: "",
			            hintContent: caption
			        },
			        {
			        	iconImageHref: 'img/instagram.png',
			        	iconImageSize: [32, 32],
			        	iconOpacity: 0.2
			        }
					);
					
					// �� ������� ������������ ���������� � ������� �� ����� �����
					 if (typeof(self.uniqUsers[element.user.id])=='undefined' || self.uniqUsers[element.user.id]===null) { 
						 self.uniqUsers[element.user.id] = element.user.username;
						 self.cluster.add(balloon);
					 }
					 else
					self.map.geoObjects.add(balloon);
					
					
					
					// ��������� ���� � ������
					$('#'+self.options.PhotoList).prepend("<li><a target='_blank' href='"+element.link+"'><img src='"+element.images.thumbnail.url+"'/></a><br/><small>"+caption.substring(0,100)+"</small></li>");
					//$('#'+self.options.PhotoList).tinycarousel({ display: 1 });
					
			//		console.log('#'+self.options.PhotoList+"div ul", element.images.thumbnail.url);
					
					// ���������� ������
					self.balloons[len] = Object.create( InstaBaloon );				
					self.balloons[len].mapobj = balloon;
					self.balloons[len].instaobj = element;
					self.balloons[len].id = element.id;
					self.balloons[len].instamap = self;
					self.balloons[len].bornat = element.created_time;
					
					//console.log('new balloon', element.id, caption, element);					
					
				});
				
			//	this.fly();
			},
			
			/*fly: function () {
								
				this.balloons.forEach(function(element, index) {
					element.fly();
				});
				
			},*/
		        
		    //Media		
			//Get the media by coords
			// tm in second
			getByCoords: function (lat, lng, tm) {
				var distance=5000;
				var from_tm = Math.round(+new Date()/1000)-tm;
				
				console.log('Search data from', new Date(from_tm*1000) );
				
					var	self=this,
					getData = '/media/search?lat='+lat+'&lng='+lng+'&distance='+distance+'&min_timestamp='+from_tm+'&access_token='+self.options.accessToken+'';					

			        this.fetch(getData).done(function ( results ) {   
			      //  	console.log('found', results);
			        	self.placePhotos(results);
			            });
				},
				
			/**
			 * ��������� ����� ������� � ������� ����
			 */
			scanMap: function() {

                $('#'+this.options.PhotoList).empty();
                this.killAll();

				var self = this,
				bounds = self.map.getBounds(),
				x1 = bounds[0][1],
				y1 = bounds[0][0],
				x2 = bounds[1][1],
				y2 = bounds[1][0],
				w = x2-x1,
				h = y2-y1,
				span = 4*self.km1,
				x_n = Math.ceil(w/(span)),
				y_n =  Math.ceil(h/(span)),
                spanW=span,
                spanH=span;

                if (spanW > w) spanW = w;
                if (spanH > h) spanH = h;

			    console.log('Bounds:',bounds);
			
				for (var i=0;i<=x_n;i++)
					for (var j=0;j<=y_n;j++)
					{
						var x11= x1 + i*spanW+spanW/2;
						var y11= y1 + j*spanH+spanH/2;
				
						console.log('getByCoords', y11, x11);
						self.getByCoords(y11, x11, this.scanTime);
					}
			},

            killAll: function() {
                this.balloons.forEach(function(element, index) {
                        element.die();
                });
                this.balloons = [];
            },

			killOld: function() {
				
				var newArr = [];
				this.balloons.forEach(function(element, index) {
					if (Math.round(+new Date()/1000)-element.bornat > element.life)
						{
						element.die();
//						delete this.balloons[this.balloons.indexOf(element)];
						}
					else
						newArr.push(element);
				});
				  this.balloons = newArr;			        
			},
			
			run: function() {
				var self = this;
				//console.log('run');
				this.scanMap();
				//this.killOld();
				
				/*if (this.runTimes>0)
				{
					this.runTimes--;
					//console.log('runtime', this.runTimes);
					setTimeout(function(){
						self.run(self.runInterval);
					}, self.runInterval * 1000);
				}*/


			}
			
		
	}