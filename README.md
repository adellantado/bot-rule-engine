<h1>Bot Rule Engine </h1>

How to use:
1. Implement IRuleFacade
2. Init RuleEngine after the Template Engine
3. Add "rules" to a scenario of the Template Engine

E.g.

    "rules": [
        {
            "name": "rule#1",
            "trigger": {"name": "blockExecuted", "block": "EgyptTourBlock"},
            "actions": [
                {"name": "hasTag", "tag": "Traveler"},
                {"name": "addTag", "tag": "Egypt"},
                {"name": "delay", "delay": "1d"},
                {"name": "sendBlock", "block": "EgyptDiscount"},
            ]
        },
        {
            "name": "rule#2",
            "trigger": {"name": "driverEvent", "event": "webhook"},
            "actions": [
                {"name": "notifyAdmin"}
            ]
        },
        {
            "name": "rule#3",
            "trigger": {"name": "newUser"},
            "actions": [
                {"name": "saveVariable", "variable": "userName", "value": "Patrick"},
                {"name": "unsubscribe"}
            ]
        },
        {
            "name": "rule#4",
            "trigger": {"name": "variableChanged", "equation": ["myVariable", ">", "5"]},
            "actions": [
                {"name": "hasVariable", "equation": ["email", "!=", ""]}
                {"name": "delay", "delay": "1d:2h:10m"},
                {"name": "notifyAdmin"}
            ]
        },
        {
            "name": "rule#5",
            "trigger": {"name": "tagAdded", "tag": "Test"},
            "actions": [
                {"name": "notifyAdmin"}
            ]
        },
        {
            "name": "rule#6",
            "trigger": {"name": "tagRemoved", "tag": "Test"},
            "actions": [
                {"name": "hasNotTag", "tag": "Test"},
                {"name": "notifyAdmin"}
            ]
        },
        {
            "name": "rule#7",
            "trigger": {"name": "variableRemoved", "variable": "TestVar"},
            "actions": [
                {"name": "removeVariable", "variable": "TestVar2"},
                {"name": "openChat"},
                {"name": "closeChat"},
                {"name": "removeTag", "tag": "TestTag"}
            ]
        },
        {
            "name": "rule#8",
            "trigger": {"name": "userInteraction", "phrase": "hey there!"},
            "actions": [
                {"name": "notifyAdmin", "email": "test@test.com", "userId": "012366334"}
            ]
        },
        {
            "name": "rule#9",
            "trigger": {"name": "paymentApproved"},
            "actions": [
                {"name": "clearVariables"}
            ]
        },
        {   
            "name": "rule#10",
            "trigger": {"name": "paymentFailed"},
            "actions": [
                {"name": "clearCache"}
            ]
        },
        {   
            "name": "rule#11",
            "trigger": {"name": "timer", "every": "5d | 1w | 1m | once", "time":"3rd 15:24 | Thu 15:24 | 15:24"},
            "actions": [
                {"name": "generateCheckoutUrl", "provider": "fondy", "description": "bike rent payment", "amount": "myVariableWithSum", "variable": "myUrl"}
            ]
        },
        {
            "name": "rule#12",
            "trigger": {"name": "external"},
            "actions": [
                {"name": "calculate", "equation": ["firstVar", "+ | - | * | /", "secondVar", "myVariable"]},
                {"name": "sendFlow", "flow": "EgyptTour"}
            ]
        },
        {  
            "name": "rule#13",
            "trigger": {"name": "referralPassed"},
            "actions": [
                {"name": "saveVariable", "variable": "referralData"},
                {"name": "validate", "value": "123", "type": "number | email | url"},
                {"name": "request", "url": "http://api.icndb.com/jokes/random", "method": "post", "data": {"name": "Alex", "sex": "male"}}
            ]
        }
    ]