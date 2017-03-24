var config = {
    lang: "zh-cn",
    time: {
        timeFormat: 24
    },
    weather: {
        params: {
            city: "广州",
            key: "04109eb09c9b4c559b72928311466038"
        }
    },
    tem_hum: {
        mqttServer:"localhost",
		mqttServerPort:9001,
		mqttclientName:"magic_mirror_tem_hum",
		temperatureTopic:"/DHT"
    },
    compliments: {
        interval: 30000,
        fadeInterval: 4000,
        morning: [
            'Good morning, handsome!',
            'Enjoy your day!',
            'How was your sleep?'
        ],
        afternoon: [
            'Hello, beauty!',
            'You look sexy!',
            'Looking good today!'
        ],
        evening: [
            'Wow, you look hot!',
            'You look nice!',
            'Hi, sexy!'
        ]
    },
    calendar: {
        maximumEntries: 10,
        url: ""
    },
    news: {
        feed: 'http://www.ftchinese.com/rss/news'
    }
}
