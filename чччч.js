!function (e) {
    var t = {};

    function n(r) {
        if (t[r]) return t[r].exports;
        var o = t[r] = {i: r, l: !1, exports: {}};
        return e[r].call(o.exports, o, o.exports, n), o.l = !0, o.exports
    }

    n.m = e, n.c = t, n.d = function (e, t, r) {
        n.o(e, t) || Object.defineProperty(e, t, {enumerable: !0, get: r})
    }, n.r = function (e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {value: "Module"}), Object.defineProperty(e, "__esModule", {value: !0})
    }, n.t = function (e, t) {
        if (1 & t && (e = n(e)), 8 & t) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var r = Object.create(null);
        if (n.r(r), Object.defineProperty(r, "default", {
            enumerable: !0,
            value: e
        }), 2 & t && "string" != typeof e) for (var o in e) n.d(r, o, function (t) {
            return e[t]
        }.bind(null, o));
        return r
    }, n.n = function (e) {
        var t = e && e.__esModule ? function () {
            return e.default
        } : function () {
            return e
        };
        return n.d(t, "a", t), t
    }, n.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, n.p = "/assets/", n(n.s = 0)
}([function (e, t) {
    var n = this && this.__awaiter || function (e, t, n, r) {
            return new (n || (n = Promise))((function (o, c) {
                function i(e) {
                    try {
                        u(r.next(e))
                    } catch (e) {
                        c(e)
                    }
                }

                function a(e) {
                    try {
                        u(r.throw(e))
                    } catch (e) {
                        c(e)
                    }
                }

                function u(e) {
                    var t;
                    e.done ? o(e.value) : (t = e.value, t instanceof n ? t : new n((function (e) {
                        e(t)
                    }))).then(i, a)
                }

                u((r = r.apply(e, t || [])).next())
            }))
        }, r = this && this.__generator || function (e, t) {
            var n, r, o, c, i = {
                label: 0, sent: function () {
                    if (1 & o[0]) throw o[1];
                    return o[1]
                }, trys: [], ops: []
            };
            return c = {
                next: a(0),
                throw: a(1),
                return: a(2)
            }, "function" == typeof Symbol && (c[Symbol.iterator] = function () {
                return this
            }), c;

            function a(c) {
                return function (a) {
                    return function (c) {
                        if (n) throw new TypeError("Generator is already executing.");
                        for (; i;) try {
                            if (n = 1, r && (o = 2 & c[0] ? r.return : c[0] ? r.throw || ((o = r.return) && o.call(r), 0) : r.next) && !(o = o.call(r, c[1])).done) return o;
                            switch (r = 0, o && (c = [2 & c[0], o.value]), c[0]) {
                                case 0:
                                case 1:
                                    o = c;
                                    break;
                                case 4:
                                    return i.label++, {value: c[1], done: !1};
                                case 5:
                                    i.label++, r = c[1], c = [0];
                                    continue;
                                case 7:
                                    c = i.ops.pop(), i.trys.pop();
                                    continue;
                                default:
                                    if (!(o = i.trys, (o = o.length > 0 && o[o.length - 1]) || 6 !== c[0] && 2 !== c[0])) {
                                        i = 0;
                                        continue
                                    }
                                    if (3 === c[0] && (!o || c[1] > o[0] && c[1] < o[3])) {
                                        i.label = c[1];
                                        break
                                    }
                                    if (6 === c[0] && i.label < o[1]) {
                                        i.label = o[1], o = c;
                                        break
                                    }
                                    if (o && i.label < o[2]) {
                                        i.label = o[2], i.ops.push(c);
                                        break
                                    }
                                    o[2] && i.ops.pop(), i.trys.pop();
                                    continue
                            }
                            c = t.call(e, i)
                        } catch (e) {
                            c = [6, e], r = 0
                        } finally {
                            n = o = 0
                        }
                        if (5 & c[0]) throw c[1];
                        return {value: c[0] ? c[1] : void 0, done: !0}
                    }([c, a])
                }
            }
        }, o = self, c = [], i = ["mainpage", "categories", "sportelement", "sportcollection", "preparesportplayback"],
        a = ["dopurchase", "login"];

    function u(e) {
        return n(this, void 0, void 0, (function () {
            var t, n, o;
            return r(this, (function (r) {
                switch (r.label) {
                    case 0:
                        return [4, caches.open("okko-cache").catch((function (e) {
                            throw e
                        }))];
                    case 1:
                        return t = r.sent(), n = f(e), [4, t.match(n).catch((function (e) {
                            throw e
                        }))];
                    case 2:
                        if (o = r.sent()) return console.warn("get responce from cache, request: ", e), [2, o];
                        throw console.error("try to get responce from cache but failed, request: ", e), new Error("No cached response")
                }
            }))
        }))
    }

    function s(e, t) {
        return t.some((function (t) {
            return -1 !== e.indexOf(t)
        }))
    }

    function f(e) {
        var t = new URL(e.url);
        return t.searchParams.delete("ts"), t.searchParams.delete("signature"), t.searchParams.delete("sid"), new Request(t.href, {
            cache: e.cache,
            method: e.method,
            headers: e.headers,
            credentials: e.credentials,
            redirect: e.redirect,
            mode: e.mode,
            referrer: e.referrer,
            integrity: e.integrity
        })
    }

    function l(e, t, o) {
        return n(this, void 0, void 0, (function () {
            var n, c, i;
            return r(this, (function (r) {
                switch (r.label) {
                    case 0:
                        return [4, e.keys(t)];
                    case 1:
                        return n = r.sent(), (c = n[0].headers.get("X-SCRAPI-CLIENT-TS")) ? [3, 3] : [4, new URL(o.url).searchParams.get("ts")];
                    case 2:
                        c = r.sent(), r.label = 3;
                    case 3:
                        return c ? [3, 5] : [4, o.json()];
                    case 4:
                        i = r.sent(), c = i.serviceInfo.serverTime, r.label = 5;
                    case 5:
                        if (!c) throw new Error("Timestamp is undefined");
                        return [2, Number(c)]
                }
            }))
        }))
    }

    o.addEventListener("install", (function (e) {
        e.waitUntil(function () {
            return n(this, void 0, void 0, (function () {
                return r(this, (function (e) {
                    switch (e.label) {
                        case 0:
                            return [4, caches.open("okko-cache").catch((function (e) {
                                throw e
                            }))];
                        case 1:
                            return e.sent().addAll(c), [2]
                    }
                }))
            }))
        }())
    })), o.addEventListener("activate", (function () {
        console.log("SW activated")
    })), o.addEventListener("message", (function () {
    })), o.addEventListener("fetch", (function (e) {
        var t = e.request;
        s(t.url, i) ? e.respondWith(function (e) {
            return n(this, void 0, void 0, (function () {
                var t, n, o, c, i;
                return r(this, (function (r) {
                    switch (r.label) {
                        case 0:
                            return [4, caches.open("okko-cache").catch((function (e) {
                                throw e
                            }))];
                        case 1:
                            return t = r.sent(), n = f(e), [4, t.match(n).catch((function (e) {
                                throw e
                            }))];
                        case 2:
                            return (o = r.sent()) ? [4, l(t, n, o).catch((function (e) {
                                throw e
                            }))] : [3, 4];
                        case 3:
                            if (c = r.sent(), (i = (new Date).getTime() - c) < 1e4 && i > 0) return [2, o];
                            throw new Error("Lifetime is expired");
                        case 4:
                            throw new Error("Response is empty");
                        case 5:
                            return [2]
                    }
                }))
            }))
        }(t).then((function () {
            return function (e) {
                return u(e)
            }(t)
        })).catch((function () {
            return function (e) {
                return function (e) {
                    return n(this, void 0, void 0, (function () {
                        var t, n;
                        return r(this, (function (r) {
                            switch (r.label) {
                                case 0:
                                    return [4, fetch(e).catch((function (e) {
                                        throw e
                                    }))];
                                case 1:
                                    return t = r.sent(), [4, t.clone().json()];
                                case 2:
                                    if (n = r.sent(), 200 === t.status && 0 !== n.status) return [2, t];
                                    if (200 === t.status && 0 === n.status) return function (e, t) {
                                        var n = f(e), r = t.clone();
                                        caches.open("okko-cache").then((function (e) {
                                            e.delete(n, {ignoreSearch: !1}).then((function () {
                                                e.put(n, r)
                                            }))
                                        }))
                                    }(e, t), [2, t];
                                    throw new Error("Bad request")
                            }
                        }))
                    }))
                }(e).catch((function () {
                    return u(e)
                }))
            }(t)
        }))) : function (e) {
            (function (e) {
                return s(e, a)
            })(e.url) && (console.log("Delete service worker's cache"), caches.delete("okko-cache"))
        }(t)
    }))
}]);