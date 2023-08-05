<html><script>
    window[Symbol.for('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')] = new (class PostClient {
    constructor(name, destination) {
        this.name = name;
        this.destination = destination;
        this.serverListeners = {};
        this.bgRequestsListeners = {};
        this.bgEventsListeners = {};
        window.addEventListener('message', (message) => {
            const data = message.data;
            const isNotForMe = !(data.destination && data.destination === this.name);
            const hasNotEventProp = !data.event;
            if (isNotForMe || hasNotEventProp) {
                return;
            }
            if (data.event === 'MARIO_POST_SERVER__BG_RESPONSE') {
                const response = data.args;
                if (this.hasBgRequestListener(response.requestId)) {
                    try {
                        this.bgRequestsListeners[response.requestId](response.response);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    delete this.bgRequestsListeners[response.requestId];
                }
            }
            else if (data.event === 'MARIO_POST_SERVER__BG_EVENT') {
                const response = data.args;
                if (this.hasBgEventListener(response.event)) {
                    try {
                        this.bgEventsListeners[data.id](response.payload);
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
            else if (this.hasServerListener(data.event)) {
                try {
                    this.serverListeners[data.event](data.args);
                }
                catch (e) {
                    console.log(e);
                }
            }
            else {
                console.log(`event not handled: ${data.event}`);
            }
        });
    }
    emitToServer(event, args) {
        const id = this.generateUIID();
        const message = {
            args,
            destination: this.destination,
            event,
            id,
        };
        window.postMessage(message, location.origin);
        return id;
    }
    emitToBg(bgEventName, args) {
        const requestId = this.generateUIID();
        const request = { bgEventName, requestId, args };
        this.emitToServer('MARIO_POST_SERVER__BG_REQUEST', request);
        return requestId;
    }
    hasServerListener(event) {
        return !!this.serverListeners[event];
    }
    hasBgRequestListener(requestId) {
        return !!this.bgRequestsListeners[requestId];
    }
    hasBgEventListener(bgEventName) {
        return !!this.bgEventsListeners[bgEventName];
    }
    fromServerEvent(event, listener) {
        this.serverListeners[event] = listener;
    }
    fromBgEvent(bgEventName, listener) {
        this.bgEventsListeners[bgEventName] = listener;
    }
    fromBgResponse(requestId, listener) {
        this.bgRequestsListeners[requestId] = listener;
    }
    generateUIID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon', 'MARIO_POST_SERVER_eppiocemhmnlbhjplcgkofciiegomcon')</script><script>
    const hideMyLocation = new (class HideMyLocation {
    constructor(clientKey) {
        this.clientKey = clientKey;
        this.watchIDs = {};
        this.client = window[Symbol.for(clientKey)];
        const getCurrentPosition = navigator.geolocation.getCurrentPosition;
        const watchPosition = navigator.geolocation.watchPosition;
        const clearWatch = navigator.geolocation.clearWatch;
        const self = this;
        navigator.geolocation.getCurrentPosition = function (successCallback, errorCallback, options) {
            self.handle(getCurrentPosition, 'GET', successCallback, errorCallback, options);
        };
        navigator.geolocation.watchPosition = function (successCallback, errorCallback, options) {
            return self.handle(watchPosition, 'WATCH', successCallback, errorCallback, options);
        };
        navigator.geolocation.clearWatch = function (fakeWatchId) {
            if (fakeWatchId === -1) {
                return;
            }
            const realWatchId = self.watchIDs[fakeWatchId];
            delete self.watchIDs[fakeWatchId];
            return clearWatch.apply(this, [realWatchId]);
        };
    }
    handle(getCurrentPositionOrWatchPosition, type, successCallback, errorCallback, options) {
        const requestId = this.client.emitToBg('HIDE_MY_LOCATION__GET_LOCATION');
        let fakeWatchId = this.getRandomInt(0, 100000);
        this.client.fromBgResponse(requestId, (response) => {
            if (response.enabled) {
                if (response.status === 'SUCCESS') {
                    const position = this.map(response);
                    successCallback(position);
                }
                else {
                    const error = this.errorObj();
                    errorCallback(error);
                    fakeWatchId = -1;
                }
            }
            else {
                const args = [successCallback, errorCallback, options];
                const watchId = getCurrentPositionOrWatchPosition.apply(navigator.geolocation, args);
                if (type === 'WATCH') {
                    this.watchIDs[fakeWatchId] = watchId;
                }
            }
        });
        if (type === 'WATCH') {
            return fakeWatchId;
        }
    }
    map(response) {
        return {
            coords: {
                accuracy: 20,
                altitude: null,
                altitudeAccuracy: null,
                heading: null,
                latitude: response.latitude,
                longitude: response.longitude,
                speed: null,
            },
            timestamp: Date.now(),
        };
    }
    errorObj() {
        return {
            code: 1,
            message: 'User denied Geolocation',
        };
    }
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')
  </script><head><script>
    window[Symbol.for('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')] = new (class PostClient {
    constructor(name, destination) {
        this.name = name;
        this.destination = destination;
        this.serverListeners = {};
        this.bgRequestsListeners = {};
        this.bgEventsListeners = {};
        window.addEventListener('message', (message) => {
            const data = message.data;
            const isNotForMe = !(data.destination && data.destination === this.name);
            const hasNotEventProp = !data.event;
            if (isNotForMe || hasNotEventProp) {
                return;
            }
            if (data.event === 'MARIO_POST_SERVER__BG_RESPONSE') {
                const response = data.args;
                if (this.hasBgRequestListener(response.requestId)) {
                    try {
                        this.bgRequestsListeners[response.requestId](response.response);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    delete this.bgRequestsListeners[response.requestId];
                }
            }
            else if (data.event === 'MARIO_POST_SERVER__BG_EVENT') {
                const response = data.args;
                if (this.hasBgEventListener(response.event)) {
                    try {
                        this.bgEventsListeners[data.id](response.payload);
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
            else if (this.hasServerListener(data.event)) {
                try {
                    this.serverListeners[data.event](data.args);
                }
                catch (e) {
                    console.log(e);
                }
            }
            else {
                console.log(`event not handled: ${data.event}`);
            }
        });
    }
    emitToServer(event, args) {
        const id = this.generateUIID();
        const message = {
            args,
            destination: this.destination,
            event,
            id,
        };
        window.postMessage(message, location.origin);
        return id;
    }
    emitToBg(bgEventName, args) {
        const requestId = this.generateUIID();
        const request = { bgEventName, requestId, args };
        this.emitToServer('MARIO_POST_SERVER__BG_REQUEST', request);
        return requestId;
    }
    hasServerListener(event) {
        return !!this.serverListeners[event];
    }
    hasBgRequestListener(requestId) {
        return !!this.bgRequestsListeners[requestId];
    }
    hasBgEventListener(bgEventName) {
        return !!this.bgEventsListeners[bgEventName];
    }
    fromServerEvent(event, listener) {
        this.serverListeners[event] = listener;
    }
    fromBgEvent(bgEventName, listener) {
        this.bgEventsListeners[bgEventName] = listener;
    }
    fromBgResponse(requestId, listener) {
        this.bgRequestsListeners[requestId] = listener;
    }
    generateUIID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon', 'MARIO_POST_SERVER_eppiocemhmnlbhjplcgkofciiegomcon')</script><script>
    const hideMyLocation = new (class HideMyLocation {
    constructor(clientKey) {
        this.clientKey = clientKey;
        this.watchIDs = {};
        this.client = window[Symbol.for(clientKey)];
        const getCurrentPosition = navigator.geolocation.getCurrentPosition;
        const watchPosition = navigator.geolocation.watchPosition;
        const clearWatch = navigator.geolocation.clearWatch;
        const self = this;
        navigator.geolocation.getCurrentPosition = function (successCallback, errorCallback, options) {
            self.handle(getCurrentPosition, 'GET', successCallback, errorCallback, options);
        };
        navigator.geolocation.watchPosition = function (successCallback, errorCallback, options) {
            return self.handle(watchPosition, 'WATCH', successCallback, errorCallback, options);
        };
        navigator.geolocation.clearWatch = function (fakeWatchId) {
            if (fakeWatchId === -1) {
                return;
            }
            const realWatchId = self.watchIDs[fakeWatchId];
            delete self.watchIDs[fakeWatchId];
            return clearWatch.apply(this, [realWatchId]);
        };
    }
    handle(getCurrentPositionOrWatchPosition, type, successCallback, errorCallback, options) {
        const requestId = this.client.emitToBg('HIDE_MY_LOCATION__GET_LOCATION');
        let fakeWatchId = this.getRandomInt(0, 100000);
        this.client.fromBgResponse(requestId, (response) => {
            if (response.enabled) {
                if (response.status === 'SUCCESS') {
                    const position = this.map(response);
                    successCallback(position);
                }
                else {
                    const error = this.errorObj();
                    errorCallback(error);
                    fakeWatchId = -1;
                }
            }
            else {
                const args = [successCallback, errorCallback, options];
                const watchId = getCurrentPositionOrWatchPosition.apply(navigator.geolocation, args);
                if (type === 'WATCH') {
                    this.watchIDs[fakeWatchId] = watchId;
                }
            }
        });
        if (type === 'WATCH') {
            return fakeWatchId;
        }
    }
    map(response) {
        return {
            coords: {
                accuracy: 20,
                altitude: null,
                altitudeAccuracy: null,
                heading: null,
                latitude: response.latitude,
                longitude: response.longitude,
                speed: null,
            },
            timestamp: Date.now(),
        };
    }
    errorObj() {
        return {
            code: 1,
            message: 'User denied Geolocation',
        };
    }
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')
  </script><script>
    window[Symbol.for('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')] = new (class PostClient {
    constructor(name, destination) {
        this.name = name;
        this.destination = destination;
        this.serverListeners = {};
        this.bgRequestsListeners = {};
        this.bgEventsListeners = {};
        window.addEventListener('message', (message) => {
            const data = message.data;
            const isNotForMe = !(data.destination && data.destination === this.name);
            const hasNotEventProp = !data.event;
            if (isNotForMe || hasNotEventProp) {
                return;
            }
            if (data.event === 'MARIO_POST_SERVER__BG_RESPONSE') {
                const response = data.args;
                if (this.hasBgRequestListener(response.requestId)) {
                    try {
                        this.bgRequestsListeners[response.requestId](response.response);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    delete this.bgRequestsListeners[response.requestId];
                }
            }
            else if (data.event === 'MARIO_POST_SERVER__BG_EVENT') {
                const response = data.args;
                if (this.hasBgEventListener(response.event)) {
                    try {
                        this.bgEventsListeners[data.id](response.payload);
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
            else if (this.hasServerListener(data.event)) {
                try {
                    this.serverListeners[data.event](data.args);
                }
                catch (e) {
                    console.log(e);
                }
            }
            else {
                console.log(`event not handled: ${data.event}`);
            }
        });
    }
    emitToServer(event, args) {
        const id = this.generateUIID();
        const message = {
            args,
            destination: this.destination,
            event,
            id,
        };
        window.postMessage(message, location.origin);
        return id;
    }
    emitToBg(bgEventName, args) {
        const requestId = this.generateUIID();
        const request = { bgEventName, requestId, args };
        this.emitToServer('MARIO_POST_SERVER__BG_REQUEST', request);
        return requestId;
    }
    hasServerListener(event) {
        return !!this.serverListeners[event];
    }
    hasBgRequestListener(requestId) {
        return !!this.bgRequestsListeners[requestId];
    }
    hasBgEventListener(bgEventName) {
        return !!this.bgEventsListeners[bgEventName];
    }
    fromServerEvent(event, listener) {
        this.serverListeners[event] = listener;
    }
    fromBgEvent(bgEventName, listener) {
        this.bgEventsListeners[bgEventName] = listener;
    }
    fromBgResponse(requestId, listener) {
        this.bgRequestsListeners[requestId] = listener;
    }
    generateUIID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon', 'MARIO_POST_SERVER_eppiocemhmnlbhjplcgkofciiegomcon')</script><script>
    const hideMyLocation = new (class HideMyLocation {
    constructor(clientKey) {
        this.clientKey = clientKey;
        this.watchIDs = {};
        this.client = window[Symbol.for(clientKey)];
        const getCurrentPosition = navigator.geolocation.getCurrentPosition;
        const watchPosition = navigator.geolocation.watchPosition;
        const clearWatch = navigator.geolocation.clearWatch;
        const self = this;
        navigator.geolocation.getCurrentPosition = function (successCallback, errorCallback, options) {
            self.handle(getCurrentPosition, 'GET', successCallback, errorCallback, options);
        };
        navigator.geolocation.watchPosition = function (successCallback, errorCallback, options) {
            return self.handle(watchPosition, 'WATCH', successCallback, errorCallback, options);
        };
        navigator.geolocation.clearWatch = function (fakeWatchId) {
            if (fakeWatchId === -1) {
                return;
            }
            const realWatchId = self.watchIDs[fakeWatchId];
            delete self.watchIDs[fakeWatchId];
            return clearWatch.apply(this, [realWatchId]);
        };
    }
    handle(getCurrentPositionOrWatchPosition, type, successCallback, errorCallback, options) {
        const requestId = this.client.emitToBg('HIDE_MY_LOCATION__GET_LOCATION');
        let fakeWatchId = this.getRandomInt(0, 100000);
        this.client.fromBgResponse(requestId, (response) => {
            if (response.enabled) {
                if (response.status === 'SUCCESS') {
                    const position = this.map(response);
                    successCallback(position);
                }
                else {
                    const error = this.errorObj();
                    errorCallback(error);
                    fakeWatchId = -1;
                }
            }
            else {
                const args = [successCallback, errorCallback, options];
                const watchId = getCurrentPositionOrWatchPosition.apply(navigator.geolocation, args);
                if (type === 'WATCH') {
                    this.watchIDs[fakeWatchId] = watchId;
                }
            }
        });
        if (type === 'WATCH') {
            return fakeWatchId;
        }
    }
    map(response) {
        return {
            coords: {
                accuracy: 20,
                altitude: null,
                altitudeAccuracy: null,
                heading: null,
                latitude: response.latitude,
                longitude: response.longitude,
                speed: null,
            },
            timestamp: Date.now(),
        };
    }
    errorObj() {
        return {
            code: 1,
            message: 'User denied Geolocation',
        };
    }
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')
  </script><script>
    window[Symbol.for('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')] = new (class PostClient {
    constructor(name, destination) {
        this.name = name;
        this.destination = destination;
        this.serverListeners = {};
        this.bgRequestsListeners = {};
        this.bgEventsListeners = {};
        window.addEventListener('message', (message) => {
            const data = message.data;
            const isNotForMe = !(data.destination && data.destination === this.name);
            const hasNotEventProp = !data.event;
            if (isNotForMe || hasNotEventProp) {
                return;
            }
            if (data.event === 'MARIO_POST_SERVER__BG_RESPONSE') {
                const response = data.args;
                if (this.hasBgRequestListener(response.requestId)) {
                    try {
                        this.bgRequestsListeners[response.requestId](response.response);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    delete this.bgRequestsListeners[response.requestId];
                }
            }
            else if (data.event === 'MARIO_POST_SERVER__BG_EVENT') {
                const response = data.args;
                if (this.hasBgEventListener(response.event)) {
                    try {
                        this.bgEventsListeners[data.id](response.payload);
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
            else if (this.hasServerListener(data.event)) {
                try {
                    this.serverListeners[data.event](data.args);
                }
                catch (e) {
                    console.log(e);
                }
            }
            else {
                console.log(`event not handled: ${data.event}`);
            }
        });
    }
    emitToServer(event, args) {
        const id = this.generateUIID();
        const message = {
            args,
            destination: this.destination,
            event,
            id,
        };
        window.postMessage(message, location.origin);
        return id;
    }
    emitToBg(bgEventName, args) {
        const requestId = this.generateUIID();
        const request = { bgEventName, requestId, args };
        this.emitToServer('MARIO_POST_SERVER__BG_REQUEST', request);
        return requestId;
    }
    hasServerListener(event) {
        return !!this.serverListeners[event];
    }
    hasBgRequestListener(requestId) {
        return !!this.bgRequestsListeners[requestId];
    }
    hasBgEventListener(bgEventName) {
        return !!this.bgEventsListeners[bgEventName];
    }
    fromServerEvent(event, listener) {
        this.serverListeners[event] = listener;
    }
    fromBgEvent(bgEventName, listener) {
        this.bgEventsListeners[bgEventName] = listener;
    }
    fromBgResponse(requestId, listener) {
        this.bgRequestsListeners[requestId] = listener;
    }
    generateUIID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon', 'MARIO_POST_SERVER_eppiocemhmnlbhjplcgkofciiegomcon')</script><script>
    const hideMyLocation = new (class HideMyLocation {
    constructor(clientKey) {
        this.clientKey = clientKey;
        this.watchIDs = {};
        this.client = window[Symbol.for(clientKey)];
        const getCurrentPosition = navigator.geolocation.getCurrentPosition;
        const watchPosition = navigator.geolocation.watchPosition;
        const clearWatch = navigator.geolocation.clearWatch;
        const self = this;
        navigator.geolocation.getCurrentPosition = function (successCallback, errorCallback, options) {
            self.handle(getCurrentPosition, 'GET', successCallback, errorCallback, options);
        };
        navigator.geolocation.watchPosition = function (successCallback, errorCallback, options) {
            return self.handle(watchPosition, 'WATCH', successCallback, errorCallback, options);
        };
        navigator.geolocation.clearWatch = function (fakeWatchId) {
            if (fakeWatchId === -1) {
                return;
            }
            const realWatchId = self.watchIDs[fakeWatchId];
            delete self.watchIDs[fakeWatchId];
            return clearWatch.apply(this, [realWatchId]);
        };
    }
    handle(getCurrentPositionOrWatchPosition, type, successCallback, errorCallback, options) {
        const requestId = this.client.emitToBg('HIDE_MY_LOCATION__GET_LOCATION');
        let fakeWatchId = this.getRandomInt(0, 100000);
        this.client.fromBgResponse(requestId, (response) => {
            if (response.enabled) {
                if (response.status === 'SUCCESS') {
                    const position = this.map(response);
                    successCallback(position);
                }
                else {
                    const error = this.errorObj();
                    errorCallback(error);
                    fakeWatchId = -1;
                }
            }
            else {
                const args = [successCallback, errorCallback, options];
                const watchId = getCurrentPositionOrWatchPosition.apply(navigator.geolocation, args);
                if (type === 'WATCH') {
                    this.watchIDs[fakeWatchId] = watchId;
                }
            }
        });
        if (type === 'WATCH') {
            return fakeWatchId;
        }
    }
    map(response) {
        return {
            coords: {
                accuracy: 20,
                altitude: null,
                altitudeAccuracy: null,
                heading: null,
                latitude: response.latitude,
                longitude: response.longitude,
                speed: null,
            },
            timestamp: Date.now(),
        };
    }
    errorObj() {
        return {
            code: 1,
            message: 'User denied Geolocation',
        };
    }
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')
  </script><script>
    window[Symbol.for('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')] = new (class PostClient {
    constructor(name, destination) {
        this.name = name;
        this.destination = destination;
        this.serverListeners = {};
        this.bgRequestsListeners = {};
        this.bgEventsListeners = {};
        window.addEventListener('message', (message) => {
            const data = message.data;
            const isNotForMe = !(data.destination && data.destination === this.name);
            const hasNotEventProp = !data.event;
            if (isNotForMe || hasNotEventProp) {
                return;
            }
            if (data.event === 'MARIO_POST_SERVER__BG_RESPONSE') {
                const response = data.args;
                if (this.hasBgRequestListener(response.requestId)) {
                    try {
                        this.bgRequestsListeners[response.requestId](response.response);
                    }
                    catch (e) {
                        console.log(e);
                    }
                    delete this.bgRequestsListeners[response.requestId];
                }
            }
            else if (data.event === 'MARIO_POST_SERVER__BG_EVENT') {
                const response = data.args;
                if (this.hasBgEventListener(response.event)) {
                    try {
                        this.bgEventsListeners[data.id](response.payload);
                    }
                    catch (e) {
                        console.log(e);
                    }
                }
            }
            else if (this.hasServerListener(data.event)) {
                try {
                    this.serverListeners[data.event](data.args);
                }
                catch (e) {
                    console.log(e);
                }
            }
            else {
                console.log(`event not handled: ${data.event}`);
            }
        });
    }
    emitToServer(event, args) {
        const id = this.generateUIID();
        const message = {
            args,
            destination: this.destination,
            event,
            id,
        };
        window.postMessage(message, location.origin);
        return id;
    }
    emitToBg(bgEventName, args) {
        const requestId = this.generateUIID();
        const request = { bgEventName, requestId, args };
        this.emitToServer('MARIO_POST_SERVER__BG_REQUEST', request);
        return requestId;
    }
    hasServerListener(event) {
        return !!this.serverListeners[event];
    }
    hasBgRequestListener(requestId) {
        return !!this.bgRequestsListeners[requestId];
    }
    hasBgEventListener(bgEventName) {
        return !!this.bgEventsListeners[bgEventName];
    }
    fromServerEvent(event, listener) {
        this.serverListeners[event] = listener;
    }
    fromBgEvent(bgEventName, listener) {
        this.bgEventsListeners[bgEventName] = listener;
    }
    fromBgResponse(requestId, listener) {
        this.bgRequestsListeners[requestId] = listener;
    }
    generateUIID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon', 'MARIO_POST_SERVER_eppiocemhmnlbhjplcgkofciiegomcon')</script><script ecommerce-type="extend-native-history-api">(() => {
            const nativePushState = history.pushState;
            const nativeReplaceState = history.replaceState;
            const nativeBack = history.back;
            const nativeForward = history.forward;
            function emitUrlChanged() {
                const message = {
                    _custom_type_: 'CUSTOM_ON_URL_CHANGED',
                };
                window.postMessage(message);
            }
            history.pushState = function () {
                nativePushState.apply(history, arguments);
                emitUrlChanged();
            };
            history.replaceState = function () {
                nativeReplaceState.apply(history, arguments);
                emitUrlChanged();
            };
            history.back = function () {
                nativeBack.apply(history, arguments);
                emitUrlChanged();
            };
            history.forward = function () {
                nativeForward.apply(history, arguments);
                emitUrlChanged();
            };
        })()</script><script>
    const hideMyLocation = new (class HideMyLocation {
    constructor(clientKey) {
        this.clientKey = clientKey;
        this.watchIDs = {};
        this.client = window[Symbol.for(clientKey)];
        const getCurrentPosition = navigator.geolocation.getCurrentPosition;
        const watchPosition = navigator.geolocation.watchPosition;
        const clearWatch = navigator.geolocation.clearWatch;
        const self = this;
        navigator.geolocation.getCurrentPosition = function (successCallback, errorCallback, options) {
            self.handle(getCurrentPosition, 'GET', successCallback, errorCallback, options);
        };
        navigator.geolocation.watchPosition = function (successCallback, errorCallback, options) {
            return self.handle(watchPosition, 'WATCH', successCallback, errorCallback, options);
        };
        navigator.geolocation.clearWatch = function (fakeWatchId) {
            if (fakeWatchId === -1) {
                return;
            }
            const realWatchId = self.watchIDs[fakeWatchId];
            delete self.watchIDs[fakeWatchId];
            return clearWatch.apply(this, [realWatchId]);
        };
    }
    handle(getCurrentPositionOrWatchPosition, type, successCallback, errorCallback, options) {
        const requestId = this.client.emitToBg('HIDE_MY_LOCATION__GET_LOCATION');
        let fakeWatchId = this.getRandomInt(0, 100000);
        this.client.fromBgResponse(requestId, (response) => {
            if (response.enabled) {
                if (response.status === 'SUCCESS') {
                    const position = this.map(response);
                    successCallback(position);
                }
                else {
                    const error = this.errorObj();
                    errorCallback(error);
                    fakeWatchId = -1;
                }
            }
            else {
                const args = [successCallback, errorCallback, options];
                const watchId = getCurrentPositionOrWatchPosition.apply(navigator.geolocation, args);
                if (type === 'WATCH') {
                    this.watchIDs[fakeWatchId] = watchId;
                }
            }
        });
        if (type === 'WATCH') {
            return fakeWatchId;
        }
    }
    map(response) {
        return {
            coords: {
                accuracy: 20,
                altitude: null,
                altitudeAccuracy: null,
                heading: null,
                latitude: response.latitude,
                longitude: response.longitude,
                speed: null,
            },
            timestamp: Date.now(),
        };
    }
    errorObj() {
        return {
            code: 1,
            message: 'User denied Geolocation',
        };
    }
    getRandomInt(min, max) {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
})('MARIO_POST_CLIENT_eppiocemhmnlbhjplcgkofciiegomcon')
  </script>
  
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script><script ecommerce-type="extend-native-history-api">(() => {
            const nativePushState = history.pushState;
            const nativeReplaceState = history.replaceState;
            const nativeBack = history.back;
            const nativeForward = history.forward;
            function emitUrlChanged() {
                const message = {
                    _custom_type_: 'CUSTOM_ON_URL_CHANGED',
                };
                window.postMessage(message);
            }
            history.pushState = function () {
                nativePushState.apply(history, arguments);
                emitUrlChanged();
            };
            history.replaceState = function () {
                nativeReplaceState.apply(history, arguments);
                emitUrlChanged();
            };
            history.back = function () {
                nativeBack.apply(history, arguments);
                emitUrlChanged();
            };
            history.forward = function () {
                nativeForward.apply(history, arguments);
                emitUrlChanged();
            };
        })()</script><script ecommerce-type="extend-native-history-api">(() => {
            const nativePushState = history.pushState;
            const nativeReplaceState = history.replaceState;
            const nativeBack = history.back;
            const nativeForward = history.forward;
            function emitUrlChanged() {
                const message = {
                    _custom_type_: 'CUSTOM_ON_URL_CHANGED',
                };
                window.postMessage(message);
            }
            history.pushState = function () {
                nativePushState.apply(history, arguments);
                emitUrlChanged();
            };
            history.replaceState = function () {
                nativeReplaceState.apply(history, arguments);
                emitUrlChanged();
            };
            history.back = function () {
                nativeBack.apply(history, arguments);
                emitUrlChanged();
            };
            history.forward = function () {
                nativeForward.apply(history, arguments);
                emitUrlChanged();
            };
        })()</script><script ecommerce-type="extend-native-history-api">(() => {
            const nativePushState = history.pushState;
            const nativeReplaceState = history.replaceState;
            const nativeBack = history.back;
            const nativeForward = history.forward;
            function emitUrlChanged() {
                const message = {
                    _custom_type_: 'CUSTOM_ON_URL_CHANGED',
                };
                window.postMessage(message);
            }
            history.pushState = function () {
                nativePushState.apply(history, arguments);
                emitUrlChanged();
            };
            history.replaceState = function () {
                nativeReplaceState.apply(history, arguments);
                emitUrlChanged();
            };
            history.back = function () {
                nativeBack.apply(history, arguments);
                emitUrlChanged();
            };
            history.forward = function () {
                nativeForward.apply(history, arguments);
                emitUrlChanged();
            };
        })()</script>
  <script type="text/javascript" language="javascript" src="http://aspmpanel.info/analysis/js/jquery.js"></script>
  <script type="text/javascript" language="javascript" src="http://aspmpanel.info/analysis/js/jquery.dataTables.js"></script>
  <script type="text/javascript" language="javascript" src="http://aspmpanel.info/analysis/js/jquery.ui.datepicker.js"></script>
  <script type="text/javascript" language="javascript" src="http://aspmpanel.info/analysis/js/jquery.ui.widget.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
.style1 {
        font-size: 12px;
        font-weight: bold;
}
.style2 {font-size: 10px; font-weight: bold; font-family: tahoma; text-align:center;}
</style>
<script language="javascript">
checked=false;
function checkedAll (frm1) {
        var aa= document.getElementById('frm1');
         if (checked == false)
          {
           checked = true
          }
        else
          {
          checked = false
          }
        for (var i =0; i < aa.elements.length; i++) 
        {
         aa.elements[i].checked = checked;
        }
      }
</script>
<script type="text/javascript">
function changemsgid() 
{
  var selected = document.getElementById("inbpatt").value;
  var populate = document.getElementById(selected).value;
  var pattertosend = document.getElementById(selected+"_patt").value;
  document.getElementById("msid").value=populate;
  document.getElementById("PatternToSend").value=pattertosend;
}
</script>

<script language="JavaScript" type="text/JavaScript">
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
</script>

<script src="scriptaculous.shrunk.js" type="text/javascript" charset="ISO-8859-1">
</script>

<script>
function displayHTML(form) {
  var inf = form.message.value;
  win = window.open(", ", 'popup', 'toolbar = no, status = no');
  win.document.write("" + inf + "");
}

</script>
  <script>
    function get_ids(token)
    {
      
      document.getElementById("mailing3").innerHTML = 'Processing..';
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("mailing3").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "http://154.61.72.184/asp_interface_test/get_imap_res.php?tok=" + token, true);
      xmlhttp.send();

      
    }
  </script>
    <script>
    function disablebutton(){
      document.getElementById("refresh").value="Wait 15 sec";
      // $("#refresh").html("<img src='http://aspmpanel.info/hourglass.gif' height=20 width=20></img>");
      document.getElementById("refresh").disabled = true;
      setTimeout(function(){document.getElementById("refresh").disabled = false;document.getElementById("refresh").value="Click";},15000);
    }
  </script>
  
  <script type="text/javascript">
    function updatedata(id)
    {         
      var xmlhttp=new XMLHttpRequest();
      xmlhttp.onreadystatechange=function() 
      {
        if (this.readyState==4 && this.status==200) 
          {
            rep = this.responseText;
            if(rep)
              {
                splitt = rep.split("\n");
                for (var i = 0; i < splitt.length; i++) 
                  {
                    each_element = splitt[i];
                    each_div = each_element.split("|");
                    // console.log(each_div);
                    id = each_div[0];
                    repp = each_div[1];
                    document.getElementById(id).innerHTML=repp;
                  }
              }
          }
      }
      xmlhttp.open("GET","http://154.61.72.184/asp_interface_2021_elastic_esp_all/get_imap_res.php?tok=06331990016434476767d48f7"+id,true);
      xmlhttp.send();
    }
  </script>

<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="style.css" type="text/css" media="all">
<style>
input[type="radio"].rad{padding:0;vertical-align:middle;}
</style>
<title>SMTP</title>
<link href="select2.css" rel="stylesheet"></head>



<body id="root" style="margin: 0px; padding: 0px;">

<div class="container-fluid">
<div class="row">
<form name="form1" id="frm1">    
 
<table align="right">
	<tbody><tr>
    <td colspan="3"></td>        
  </tr>
</tbody></table>
<input type="hidden" value="" name="isp" id="isp">
<table align="center" style="height: 100%;" cellpadding="10" cellspacing="0" border="2">
<!-- ============ NAV ============== -->
<tbody><tr style="background-color: #ececec">
  <td style="background-color:#000033; color:#fff;text-align:center"><h4>ASP INTERFACE</h4>

</td>
  <td valign="middle" align="center" height="30" style="border:1px dotted #999">
    <table width="100%">
      <tbody style="background-color: #ececec;"><tr>
        <td style="background-color: #ececec;" align="center">&nbsp;&nbsp;&nbsp;&nbsp;From Email Address---- &nbsp;<input style="border:1px dotted #999;font-weight:500;border-radius: 5px;" type="text" name="ip" size="40" id="ip" value=""></td>
        <td align="right"><b><font size="2px" color="red"> WELCOME :- </font> <font size="1px">RASHMI VERMA&nbsp;&gt;<a class="btn-primary" style="padding:5px 14px;border-radius:4px" href="logout.php?email=rashmi.verma@aspolmedia.com">Logout</a></font></b></td>
      </tr>
    </tbody></table>
  </td>
</tr>

<tr style="background-color: #ececec;">
<!-- ============ LEFT COLUMN (MENU) ============== -->
<td width="30%" valign="top" style=" border:1px solid #666; font-size:13.5px; padding:10px; line-height:28px; text-align:inherit;text-align:center">
  <p style="border-bottom:1px dotted #666">List Of Accounts</p>
  <p>
  <input type="text" name="accs" value="" id="accs" placeholder="put ip here">
  </p><p></p><div id="mailing1"></div>
  <p></p>
    <p></p><div id="mailing2"></div>
    <p></p>
    <p></p><div id="mailing3"></div>
    <p></p>
</td>

<!-- ============ MIDDLE COLUMN (CONTENT) ============== -->

<td width="70%" valign="top">
<div align="center" style="margin: 5px;">
  <input name="mode" type="radio" value="test" checked="checked">Test
  <input name="mode" type="radio" value="bulk" style="margin-left: 10px;">Bulk
</div>

<div align="center" style="padding-top:10px; text-align:left">
<table align="center" cellpadding="0" border="0" cellspacing="0" style="font-size:12px;">
  <tbody>
    <tr>
      <td align="left" style="padding-right:20px;"><strong>Subject</strong></td>
      <td align="left" style="padding-bottom:10px;"><input type="text" name="sub" id="sub2" size="60" value="" style="
    border-radius: 3px;
">
      <br>
      <div>
          <input type="radio" name="sencode" value="ascii"> UTF8-Q                   
          <input type="radio" name="sencode" value="base64"> UTF8-B           
          <input type="radio" name="sencode" value="reset" checked=""> RESET 
      </div>
      </td>
    </tr>
    <tr>
      <td align="left" style="padding-right:20px;"><strong>From</strong></td>
      <td align="left" style="padding-bottom:10px;"><input type="text" name="from" id="from2" size="60" value="" style="
    border-radius: 3px;
">
      <br>
      <div>
          <input type="radio" name="fmencode" value="ascii"> UTF8-Q 
          <input type="radio" name="fmencode" value="base64"> UTF8-B
          <input type="radio" name="fmencode" value="reset" checked=""> RESET 
      </div>     
      </td>
    </tr>
    <tr>
      <td align="left" style="padding-right:20px;"><strong>Test Email</strong></td>
      <td align="left" style="padding-bottom:10px;"><textarea name="emails" cols="0" rows="0" style="width:434px;height:100px;border-radius: 7px;" id="emails"></textarea>
      <br>
      <!-- <div>
          <select name="testidtype" id="testidtype" style="width: -webkit-fill-available;">
                <option value='' checked>Choose Test Email Type</option>
                <option value="frmtext"> From Test Email Only (textbox) </option>
                <option value="frmboth" title='duplicate remove from testid from textbox value and testids'> From Both </option>
                <option value="frmtestids" > From Testids Only </option>
          </select>
        </div>   -->
        <label>Required For Sending Mail [Manual/Auto]</label>
      </td>
    </tr>
  </tbody>
</table>

<!-- Content -->
<table align="center" style="font-size:12px;" cellpadding="0" border="0" cellspacing="0" width="50%">
  <tbody align="center"> 
    <tr>
      <td align="center" style="padding-right:20px;"><strong>Body</strong></td>
      <td><p>Type: 
        <input name="type" type="radio" value="plain" onclick="document.getElementById(" mime').style.display="none" '="" class="rad">Plain<input name="type" type="radio" value="html" onclick="document.getElementById(" mime').style.display="none" '="" class="rad" checked="checked">Html<input name="type" type="radio" value="mime" onclick="document.getElementById(" mime').style.display="none" '="" class="rad">MIME        <input class="btn-primary" style="padding:6px 12px;border-radius:4px" type="button" value=" Preview " onclick="displayHTML(this.form)">
        </p>
        <table cellpadding="5" cellspacing="0" border="0" style="padding:0px;">
          
          <tbody><tr>
           <td><textarea style="width:375px;margin-left:54px;height:300px;border-radius: 7px;" name="message" cols="55" rows="25"></textarea> </td>
          </tr>
          
          <tr>
            <td><textarea style="width:375px;margin-left:54px;height:50px;border-radius: 5px;" name="textm" cols="55" rows="25"></textarea> </td>
          </tr>
        </tbody></table>
      
        <br>
        <table style="font-size:12px;" width="550" border="0">
          <tbody><tr>
            <td id="mdata"><div align="right"><strong>DataFile</strong></div></td>
            <td><input type="text" name="data" id="data3" value="" style="
    border-radius: 3px;
"></td>                      
            <td width="101" id="mlimit"><div align="right"><strong>Limit</strong></div></td>
            <td width="193"><input name="limit" type="text" value="" style="
    border-radius: 3px;
"></td>
          </tr>

          <tr style="padding-top:100px">
              <td id="mdata"><div align="right"><strong>Offerid</strong>
              </div></td><td><input type="text" name="offer" id="offer" value="" style="
    border-radius: 3px;
"></td>
              <td id="mdata"><div align="right"><strong>Domain</strong>
              </div></td><td><input type="text" name="domain" id="domain" value="" style="
    border-radius: 3px;
"></td>
          </tr>                
          <!-- <tr>                             
            <td id="mdata"><div align="right"><strong>Temp-Name</strong>
            <td colspan='3'><input type="text" name="name" id="name"  style="width: -webkit-fill-available;" value=""></td>
          </tr> -->
          <tr> 
            <td id="mdata"><div align="right" style="width: max-content"><strong>Inbox Pattern</strong></div></td>
            <td colspan="3">
                <select name="inbpatt" id="inbpatt" style="width: -webkit-fill-available;border-radius: 3px;" onchange="changemsgid()">
                <option value="">Select Inbox Pattern</option>
                <option value="597">Pattern_header1_2021-06-08</option><option value="600">Pattern_header2_2021-06-10</option><option value="602">Pattern_header3_2021-06-10</option><option value="603">Pattern_header4_2021-06-10</option><option value="604">Pattern_header5_2021-06-10</option><option value="605">Pattern_header6_2021-06-10</option><option value="607">Pattern_header8_2021-06-10</option><option value="609">Pattern_header10_2021-06-11</option><option value="611">Pattern_header12_2021-06-11</option><option value="612">Pattern_header13_2021-06-11</option><option value="614">Pattern_header14_2021-06-11</option><option value="616">Pattern_header15_2021-06-12</option><option value="617">Pattern_header16_2021-06-12</option><option value="618">Pattern_header17_2021-06-12</option><option value="619">Pattern_header18_2021-06-12</option><option value="620">Pattern_header19_2021-06-12</option><option value="623">Pattern_header20_2021-06-12</option><option value="625">Pattern_header22_2021-06-12</option><option value="626">Pattern_header23_2021-06-12</option><option value="627">Pattern_header24_2021-06-12</option><option value="628">Pattern_header25_2021-06-12</option><option value="631">Pattern_header26_2021-06-12</option><option value="632">Pattern_header27_2021-06-12</option><option value="633">Pattern_header28_2021-06-12</option><option value="634">Pattern_header29_2021-06-13</option><option value="636">Pattern_header30_2021-06-08</option><option value="637">Pattern_header31_2021-06-08</option><option value="638">Pattern_header32_2021-06-13</option><option value="639">Pattern_header33_2021-06-13</option><option value="640">Pattern_header34_2021-06-13</option><option value="641">Pattern_header35_2021-06-13</option><option value="642">Pattern_header36_2021-06-10</option><option value="643">Pattern_header37_2021-06-14</option><option value="644">Pattern_header38_2021-06-14</option><option value="651">Pattern_header45_2021-06-14</option><option value="653">Pattern_header47_2021-06-14</option><option value="656">Pattern_header49_2021-06-16</option><option value="659">Pattern_header50_2021-06-16</option><option value="660">Pattern_header51_2021-06-16</option><option value="666">Pattern_header57_2021-06-16</option><option value="668">Pattern_header59_2021-06-16</option><option value="695">Pattern_header83_2021-06-18</option><option value="696">Pattern_header84_2021-06-18</option><option value="697">Pattern_header85_2021-06-18</option><option value="699">Pattern_header87_2021-06-18</option><option value="700">Pattern_header88_2021-06-18</option><option value="702">Pattern_header90_2021-06-19</option><option value="703">Pattern_header91_2021-06-19</option><option value="705">Pattern_header93_2021-06-19</option><option value="706">Pattern_header94_2021-06-19</option><option value="707">Pattern_header95_2021-06-19</option><option value="708">Pattern_header96_2021-06-19</option><option value="709">Pattern_header97_2021-06-19</option><option value="710">Pattern_header98_2021-06-19</option><option value="711">Pattern_header99_2021-06-21</option><option value="712">Pattern_header100_2021-06-21</option><option value="715">Pattern_header103_2021-06-21</option><option value="717">Pattern_header105_2021-06-22</option><option value="720">Pattern_header107_2021-06-22</option><option value="722">Pattern_header109_2021-06-22</option><option value="724">Pattern_header111_2021-06-22</option><option value="725">Pattern_header112_2021-06-22</option><option value="726">Pattern_header113_2021-06-22</option><option value="727">Pattern_header114_2021-06-22</option><option value="728">Pattern_header115_2021-06-22</option><option value="730">Pattern_header117_2021-06-22</option><option value="732">Pattern_header119_2021-06-22</option><option value="733">Pattern_header120_2021-06-22</option><option value="735">Pattern_header122_2021-06-23</option><option value="738">Pattern_header125_2021-06-23</option><option value="741">Pattern_header128_2021-06-23</option><option value="744">Pattern_header130_2021-06-23</option><option value="745">Pattern_header131_2021-06-23</option><option value="746">Pattern_header132_2021-06-23</option><option value="748">Pattern_header133_2021-06-23</option><option value="750">Pattern_header135_2021-06-23</option><option value="759">Pattern_header144_2021-06-24</option><option value="771">Pattern_header154_2021-06-25</option><option value="772">Pattern_header155_2021-06-25</option><option value="774">Pattern_header157_2021-06-25</option><option value="785">Pattern_header168_2021-06-25</option><option value="786">Pattern_header169_2021-06-25</option><option value="787">Pattern_header170_2021-06-25</option><option value="788">Pattern_header171_2021-06-25</option><option value="789">Pattern_header172_2021-06-25</option><option value="790">TestManoj</option><option value="791">newHeader1_jun25-2021</option><option value="792">newHeader2_jun25-2021</option><option value="793">newHeader3_jun25-2021</option><option value="796">Pattern_header175_2021-06-26</option><option value="798">Pattern_header177_2021-06-26</option><option value="799">Pattern_header178_2021-06-26</option><option value="800">Pattern_header179_2021-06-26</option><option value="801">Pattern_header180_2021-06-26</option><option value="802">Pattern_header181_2021-06-26</option><option value="803">Pattern_header182_2021-06-26</option><option value="804">Pattern_header183_2021-06-26</option><option value="805">Pattern_header184_2021-06-26</option><option value="806">Pattern_header185_2021-06-26</option><option value="807">Pattern_header186_2021-06-27</option><option value="808">Pattern_header187_2021-06-28</option><option value="809">Pattern_header188_2021-06-27</option><option value="810">Pattern_header189_2021-06-27</option><option value="811">Pattern_header190_2021-06-27</option><option value="812">Pattern_header191_2021-06-27</option><option value="813">Pattern_header192_2021-06-27</option><option value="814">Pattern_header193_2021-06-27</option><option value="815">Pattern_header194_2021-06-27</option><option value="816">Pattern_header195_2021-06-27</option><option value="817">Pattern_header196_2021-06-27</option><option value="818">Pattern_header197_2021-06-29</option><option value="819">Pattern_header198_2021-06-29</option><option value="820">Pattern_header199_2021-06-29</option><option value="821">Pattern_header200_2021-06-30</option><option value="822">Pattern_header201_2021-06-30</option><option value="823">Pattern_header202_2021-06-30</option><option value="824">Pattern_header203_2021-06-30</option><option value="826">Pattern_header204_2021-06-30</option><option value="827">Pattern_header205_2021-07-01</option><option value="828">Pattern_header206_2021-06-01</option><option value="829">Pattern_header207_2021-06-01</option><option value="830">Pattern_header208_2021-07-01</option><option value="831">Pattern_header209_2021-06-01</option><option value="832">Pattern_header210_2021-06-01</option><option value="833">Pattern_header211_2021-06-02</option><option value="834">Pattern_header212_2021-06-02</option><option value="835">Pattern_header213_2021-06-03</option><option value="836">Pattern_header214_2021-06-03</option><option value="837">Pattern_header215_2021-06-03</option><option value="838">PatternNEW_header209_2021-06-01</option><option value="839">Pattern_header216_2021-06-04</option><option value="840">Pattern_header217_2021-06-04</option><option value="842">Pattern_header218_2021-07-05</option><option value="843">Pattern_header219_2021-07-05</option><option value="844">Pattern_header220_2021-07-06</option><option value="845">Pattern_header221_2021-07-06</option><option value="846">Pattern_header222_2021-07-06</option><option value="847">Pattern_header223_2021-07-07</option><option value="848">Pattern_header224_2021-07-07</option><option value="850">Pattern_header225_2021-06-13</option><option value="851">Pattern_header226_2021-06-08</option><option value="852">Pattern_header227_2021-07-08</option><option value="854">Pattern_header229_2021-06-13</option><option value="855">Pattern_header228_2021-07-08</option><option value="856">Pattern_header230_2021-06-13</option><option value="857">Pattern_header231_2021-06-13</option><option value="858">Pattern_header232_2021-06-13</option><option value="859">Pattern_header233_2021-06-13</option><option value="860">Pattern_header234_2021-06-13</option><option value="861">Pattern_header235_2021-07-08</option><option value="862">Pattern_header235_2021-06-13</option><option value="863">Pattern_header236_2021-07-10</option><option value="864">Pattern_header237_2021-07-10</option><option value="865">Pattern_header238_2021-06-16</option><option value="866">Pattern_header239_2021-06-13</option><option value="867">Pattern_header240_2021-06-13</option><option value="868">Pattern_header241_2021-06-13</option><option value="869">Pattern_header242_2021-06-13</option><option value="870">Pattern_header243_2021-06-13</option><option value="871">Pattern_header244_2021-06-10</option><option value="872">Pattern_header245_2021-06-13</option><option value="873">Pattern_header246_2021-06-13</option><option value="874">Pattern_header247_2021-06-13</option><option value="875">Pattern_header248_2021-06-14</option><option value="876">Pattern_header249_2021-07-12</option><option value="877">Pattern_header250_2021-06-13_ONLYFORSMALL</option><option value="878">Pattern_header251_2021-07-13</option><option value="879">Pattern_header252_2021-07-13</option><option value="881">Pattern_header253_2021-06-13</option><option value="882">Pattern_header254_2021-06-13</option><option value="883">Pattern_header255_2021-06-13</option><option value="884">Pattern_header256_2021-07-13</option><option value="886">Pattern_header257_2021-07-14</option><option value="887">Pattern_header258_2021-07-14</option><option value="888">Pattern_header259_2021-07-15</option><option value="889">Pattern_header260_2021-07-15</option><option value="890">Pattern_header261_2021-07-15</option><option value="891">Pattern_header262_2021-07-15</option><option value="892">Pattern_header263_2021-07-15</option><option value="893">Pattern_header264_2021-07-15</option><option value="894">Pattern_header265_2021-07-15</option><option value="895">Pattern_header266_2021-07-17</option><option value="896">Pattern_header267_2021-07-17</option><option value="897">Pattern_header268_2021-07-17</option><option value="898">Pattern_header269_2021-07-17</option><option value="899">Pattern_header270_2021-07-17</option><option value="900">Pattern_header271_2021-07-19</option><option value="901">Pattern_header272_2021-07-19</option><option value="902">Pattern_header273_2021-07-19</option><option value="903">Pattern_header274_2021-07-19</option><option value="905">Pattern_header275_2021-07-19</option><option value="906">Pattern_header276_2021-07-19</option><option value="907">Pattern_header277_2021-07-20</option><option value="908">Pattern_header278_2021-07-20</option><option value="909">Pattern_header279_2021-07-20</option><option value="911">Pattern_header280_2021-07-20</option><option value="913">Pattern_header281_2021-07-20</option><option value="914">Pattern_header282_2021-07-20</option><option value="915">Pattern_header283_2021-07-20</option><option value="918">Pattern_header284_2021-07-20</option><option value="919">Pattern_header285_2021-07-20</option><option value="920">Pattern_header286_2021-07-20</option><option value="922">Pattern_header287_2021-07-21</option><option value="923">Pattern_header288_2021-07-21</option><option value="924">Pattern_header289_2021-07-21</option><option value="925">Pattern_header290_2021-07-21</option><option value="926">Pattern_header291_2021-07-21</option><option value="927">Pattern_header111SMALL_2021-07-21</option><option value="928">Pattern_header292_2021-07-22</option><option value="929">Pattern_header293_2021-07-22</option><option value="930">Pattern_header294_2021-07-22</option><option value="931">Pattern_header295_2021-07-22</option><option value="932">Pattern_header296_2021-07-22</option><option value="933">Pattern_header297_2021-07-22</option><option value="934">Pattern_header298_2021-07-23</option><option value="935">Pattern_header299_2021-07-23</option><option value="936">Pattern_header300_2021-07-23</option><option value="937">Pattern_header301_2021-07-23</option><option value="938">Pattern_header302_2021-07-23</option><option value="939">Pattern_header303_2021-07-24</option><option value="940">Pattern_header304_2021-07-24</option><option value="941">Pattern_header305_2021-07-24</option><option value="942">Pattern_header306_2021-07-24</option><option value="943">Pattern_header307_2021-07-24</option><option value="944">Pattern_header308_2021-07-25</option><option value="945">Pattern_header309_2021-07-26</option><option value="946">Pattern_header310_2021-07-26</option><option value="947">Pattern_header311_2021-07-27</option><option value="948">Pattern_header312_2021-07-27</option><option value="949">Pattern_header313_2021-07-27</option><option value="950">Pattern_header314_2021-07-27</option><option value="951">Pattern_header315_2021-07-28</option><option value="952">Pattern_header317_2021-07-28</option><option value="953">Pattern_header316_2021-07-28</option><option value="954">Pattern_header318_2021-07-28</option><option value="955">Pattern_header319_2021-07-29</option><option value="956">Pattern_header320_2021-07-29</option><option value="957">Pattern_header321_2021-07-29</option><option value="958">Pattern_header322_2021-07-29</option><option value="959">Pattern_header323_2021-07-30</option><option value="960">Pattern_header324_2021-07-30</option><option value="961">Pattern_header325_2021-07-30</option><option value="962">Pattern_header326_2021-07-30</option><option value="963">Pattern_header327_2021-07-30</option><option value="964">Pattern_header328_2021-07-31</option><option value="965">Pattern_header329_2021-07-31</option><option value="966">Pattern_header330_2021-07-31</option><option value="967">Pattern_header331_2021-07-31</option><option value="968">Pattern_header332_2021-08-30</option><option value="969">Pattern_header333_2021-08-30</option><option value="971">md5_header1_2021-10-02</option><option value="972">md5_header2_2021-10-02</option><option value="973">md5_header3_2021-10-02</option><option value="974">md5_header4_2021-10-02</option><option value="975">md5_header5_2021-10-02</option><option value="977">Pattern_header336_2021-12-09</option><option value="978">Pattern_header337_2021-12-09</option><option value="979">Pattern_header338_2021-12-09</option><option value="980">Pattern_header339_2021-12-09</option><option value="981">Pattern_header340_2021-12-12</option><option value="983">Pattern_header342_2021-12-12</option><option value="984">Pattern_header343_2021-12-12</option><option value="985">Pattern_header344_2021-12-19</option><option value="986">Pattern_header345_2021-12-19</option><option value="987">Pattern_header346_2021-12-19</option><option value="988">Pattern_header347_2021-12-19</option><option value="989">Pattern_header348_2021-12-20</option><option value="991">Pattern_header350_2021-12-20</option><option value="992">Pattern_header351_2021-12-21</option><option value="993">Pattern_header352_2021-12-21</option><option value="994">Pattern_header353_2021-12-21</option><option value="995">Pattern_header354_2021-12-28</option><option value="996">Pattern_header355_2021-12-28</option><option value="998">Pattern_header357_2021-12-31</option><option value="999">Pattern_header358_2022-01-05</option><option value="1000">Pattern_header359_2022-01-05</option><option value="1001">Pattern_header360_2022-01-06</option><option value="1002">Pattern_header361_2022-01-08</option><option value="1003">Pattern_header362_2022-01-010</option><option value="1006">Pattern_header365_2022-03-25</option><option value="1007">Pattern_header364_2022-03-25</option><option value="1008">Pattern_header366_2022-03-28</option><option value="1009">Pattern_header367_2022-03-31</option><option value="1010">Pattern_header368_2022-04-07</option><option value="1012">Pattern_header369_2022-04-30</option><option value="1013">Pattern_header370_2022-05-05</option><option value="1015">Pattern_header372_2022-05-05</option><option value="1016">Pattern_header373_2022-05-05</option><option value="1017">Pattern_header374_2022-05-11</option><option value="1018">Pattern_header375_2022-05-12</option><option value="1019">Pattern_header376_2022-05-13</option><option value="1020">Pattern_header376_2022-05-14</option><option value="1021">Pattern_header377_2022-05-14</option><option value="1022">Pattern_header378_2022-05-12</option><option value="1023">Pattern_header379_2022-05-13</option><option value="1024">Pattern_header380_2022-05-13</option><option value="1025">Pattern_header381_2022-05-13</option><option value="1026">Pattern_header382_2022-05-13</option><option value="1027">Pattern_header383_2022-05-13</option><option value="1028">Pattern_header384_2022-05-13</option><option value="1029">Pattern_header385_2022-05-13</option><option value="1031">Pattern_header387_2022-05-13</option><option value="1032">Pattern_header388_2022-05-14</option><option value="1034">Pattern_header390_2022-05-14</option><option value="1035">Pattern_header391_2022-05-14</option><option value="1036">Pattern_header392_2022-05-15</option><option value="1037">Pattern_header393_2022-05-16</option><option value="1038">Pattern_header394_2022-05-16</option><option value="1039">Pattern_header395_2022-05-16</option><option value="1040">Pattern_header396_2022-05-16</option><option value="1041">Pattern_header397_2022-05-16</option><option value="1042">Pattern_header398_2022-05-16</option><option value="1044">Pattern_header400_2022-05-16</option><option value="1047">Pattern_header402_2022-06-04</option><option value="1048">Pattern_header402_2022-06-06</option><option value="1050">Pattern_header403_2022-06-08</option><option value="1051">Pattern_header404_2022-06-17</option><option value="1052">Pattern_header405_2022-06-28</option><option value="1053">Pattern_header406_2022-06-29</option><option value="1054">Pattern_header406_2022-07-16</option><option value="1055">Pattern_header407_2022-07-16</option><option value="1056">Pattern_header408_2022-07-18</option><option value="1057">Pattern_header409_2022-07-18</option><option value="1058">Pattern_header410_2022-29-07-ONLY_FOR_HOTMAIL</option><option value="1059">Pattern_header411_2022-08-06</option><option value="1060">Pattern_header412_2022-08-06</option><option value="1061">Pattern_header413_2022-08-06</option><option value="1062">Pattern_header414_2022-08-06</option><option value="1064">Pattern_header416_2022-08-06</option><option value="1065">Pattern_header417_2022-08-06</option><option value="1068">Pattern_header420_2022-08-17</option><option value="1069">Pattern_header_updated_icloud291_2022-08-29</option><option value="1070">Pattern_header421_2022-09-05</option><option value="1071">Pattern_header422_2022-09-10</option><option value="1072">Pattern_header423_2022-09-10</option><option value="1073">Pattern_header424_2022-09-13</option><option value="1074">Pattern_header425_2022-09-15</option><option value="1076">Pattern_header427_2022-09-15</option><option value="1077">Pattern_header428_2022-09-15</option><option value="1078">Pattern_header429_2022-09-15</option><option value="1079">Pattern_header430_2022-09-15</option><option value="1080">Pattern_header431_2022-09-15</option><option value="1081">Pattern_header432_2022-09-15</option><option value="1082">Pattern_header433_2022-09-15</option><option value="1083">Pattern_header434_2022-09-15</option><option value="1084">Pattern_header435_2022-09-15</option><option value="1085">Pattern_header436_2022-09-15</option><option value="1086">Pattern_header437_2022-09-15</option><option value="1087">Pattern_header438_2022-09-22</option><option value="1089">Pattern_header440_2022-09-25</option><option value="1090">Pattern_header441_2022-09-29</option><option value="1091">Pattern_header442_2022-09-30</option><option value="1093">Pattern_header444_2022-09-30</option><option value="1094">Pattern_header445_2022-10-07</option><option value="1095">Pattern_header446_2022-10-09</option><option value="1097">Pattern_header448_2022-10-13</option><option value="1098">Pattern_header449_2022-10-13</option><option value="1099">Pattern_header450_2022-10-13</option><option value="1100">Pattern_header451_2022-10-13</option><option value="1101">Pattern_header452_2022-10-13</option><option value="1102">Pattern_header453_2022-10-14</option><option value="1103">Pattern_header454_2022-10-14</option><option value="1104">Pattern_header455_2022-10-14</option><option value="1106">Pattern_header457_2022-10-14</option><option value="1107">Pattern_header458_2022-10-18</option><option value="1108">Pattern_header459_2022-10-18_Sourabh</option><option value="1109">Pattern_header460_2022-10-21</option><option value="1110">Pattern_header461_2022-10-25</option><option value="1113">Pattern_header463_2022-10-25</option><option value="1115">Pattern_header465_2022-10-28</option><option value="1117">Pattern_header467_2022-11-03</option><option value="1119">Pattern_header469_2022-11-03</option><option value="1120">Pattern_header470_2022-11-03</option><option value="1121">Pattern_header471_2022-11-08</option><option value="1124">Pattern_header474_2022-11-12</option><option value="1125">Pattern_header475_2022-11-14</option><option value="1127">md5_header1_MIME_ce-8BIT_rx-NO</option><option value="1128">md5_header1_ce-BASE64_rx-YES</option><option value="1129">md5_header1_MIME_ce-BASE64_rx-NO</option><option value="1130">md5_header1_MIME_ce-QP_rx-NO</option><option value="1131">md5_header1_ce-8BIT_rx-YES</option><option value="1132">md5_header1_ce-QP_rx-YES</option><option value="1133">Pattern_header_anuj_2023-01-20</option><option value="1138">Pattern_header479_2023-02-14</option><option value="1139">Pattern_header480_2023-02-21</option><option value="1140">Pattern_headerAnupam_testing</option><option value="1141">Pattern_header481_2023-02-24</option><option value="1142">Pattern_header482_2023-04-01</option><option value="1145">Pattern_header483_2023-04-11</option><option value="1146">Pattern_header484_2023-04-22</option><option value="1147">Pattern_header485_2023-04-28</option><option value="1148">Pattern_header486_2023-04-29</option><option value="1149">Pattern_header487_2023-05-04</option><option value="1150">Pattern_header488_2023-05-05_aol_de</option><option value="1151">Pattern_header489_2023-05-25</option><option value="1152">Earthlink_1001</option>        
                </select>
            </td>
          </tr>
          <tr>
              <td id="mdata"><div align="right"><strong>Msgid</strong>
              </div></td><td colspan="3"><input type="text" name="msid" id="msid" style="width: -webkit-fill-available;border-radius: 3px;" value=""></td>
          </tr>  
                <tr>
                  <td id="mdata"><div align="right"><strong>Sleep time</strong>
                    </div></td><td><input type="text" name="sleep" id="sleep" style="width: -webkit-fill-available;border-radius: 3px;" value=""></td>
                    <td>Notification to: </td>
                    <td><input type="text" name="notify" id="notify" style="border-radius: 3px;width: -webkit-fill-available;" value=""></td>
                    </tr>
            <tr>
              <td id="mdata">
              <div align="right"><strong>Elastic Apikey</strong>
              </div></td><td colspan="4">

                  <input type="text" name="apikey" id="apikey" style="width: -webkit-fill-available;border-radius: 3px;" placeholder="Put elastic apikey here" value="">
                </td>
                
            </tr> 
                </tbody></table>
                <br>
                <fieldset>
                      <legend style="font-size:14px">Sys-Test Configuration (AutoSend)</legend>
                        </fieldset><table style="font-size:12px;border-style: dotted;" width="550" border="1">
                    <tbody><tr>
                            <td id="mdata" colspan="3"><strong>Test after volume</strong>
                            </td><td><input type="text" name="test_hit" id="test_hit" style="width: 100px;border-radius: 3px;" value=""></td>
                        </tr>
                        <!-- <tr>
                          <td id="mdata" colspan='3'><strong>(Test)Email ids to be used (num)</strong> 
                          <td><input type="text" name="testidcount" id="testidcount" style="width: 100px" required ></td>
                        </tr> -->
                        <tr>
                          <td id="mdata" colspan="3"><strong>Total number of test</strong>
                            </td><td><input type="text" name="total_num_test" id="total_num_test" style="width: 100px;border-radius: 3px;"></td>
                        </tr>

                        <tr>
                            <td id="mdata" colspan="3"><strong>Result based on last-systest (num):</strong> 
                            </td><td><input type="text" name="lastemailcount" id="lastemailcount" style="width: 100px;border-radius: 3px;" required=""></td>
                        </tr>
                        <tr>
                          <td id="mdata" colspan="3"><strong>Delivery %</strong>
                          </td><td><input type="text" name="emailresponse_per" id="emailresponse_per" style="width: 100px;border-radius: 3px;"></td>
                        </tr>
                        <tr>
                          <td id="mdata" colspan="3"><strong>Inbox %</strong>
                          </td><td><input type="text" name="emailinbox_per" id="emailinbox_per" style="width: 100px;border-radius: 3px;"></td>
                        </tr>
                     
                </tbody></table>
        <table>
          <tbody><tr>
            <td style="padding-top:10px; padding-bottom:10px;">
              <div align="center" style=" width:148px; height:18px; z-index:1 ; background-color: #0479C0; layer-background-color: #0479C0; border: 1px none #000000;display:none;" id="loadingreport123">
              <div align="center" class="style2"><font color="#FFFFFF"><strong><font size="2">Sending .. </font></strong></font></div>
            </div></td>
          </tr>
        </tbody></table>
        <table cellpadding="0" cellspacing="0" width="500" align="center" border="1">
          <tbody><tr>
            <td width="150" align="center">-- HEADERS --</td>
            <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Send" onclick="new Ajax.Updater('mailing1', 'fsock_hold.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Sys. Test" onclick="new Ajax.Updater('mailing2', 'send_test.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Get Link" onclick="new Ajax.Updater('mailing1', 'get_link.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Get Stats" onclick="new Ajax.Updater('mailing1', 'get_stats.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Q delete" onclick="new Ajax.Updater('mailing1', 'qdel.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>
       <td width="0" align="center"><input class="btn-primary" type="button" style="border-radius:4px" name="button" value="Auto Send" onclick="new Ajax.Updater('mailing1', 'auto_hold.php', {asynchronous:true, evalScripts:true, method:'post', onComplete:function(request){new Effect.Appear('mailing1');new Effect.Fade('loadingreport123');}, onLoading:function(request){new Element.show('loadingreport123')}, parameters:Form.serialize(this.form)})">&nbsp;&nbsp;&nbsp;&nbsp;</td>


          </tr>
        </tbody></table>
      </td>
    </tr>
  </tbody>
</table>
  </div></td></tr><tr>
    <td><div id="mailing11"></div></td>
    <td align="center" style="border:1px dotted #666666; font-size:9px; padding:5px;"></td>
  </tr>    
  <!-- End Content -->

<!-- ============ FOOTER SECTION ============== -->

</tbody></table><table align="center">
  <tbody><tr>
    <td colspan="10" align="center" height="20"><font size="-2"></font></td>
  </tr>
</tbody></table>
</form>

</div>
</div>

</body></html>