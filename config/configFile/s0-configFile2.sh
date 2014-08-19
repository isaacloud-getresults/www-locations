 #!/bin/bash
## Init
set -e
cd "$(dirname "$0")"
. ../tools/init 

echo "### Step 0: IsaaCloud authentication"

GET_TOKEN $1
if [ "$IC_TOKEN" == "null" ]; then
	echo "Unable to get token - check your '$1' secret key"
	exit 1
fi	

echo 
echo '### Step 1: Create Transaction Source'

_BODY='{"description": "Transaction source for transactions",
	    "name":"transactionSource", 
	    "functions":[] }'
TRANSACTION_SOURCE_ID=`IC_POST /admin/transactionsources "$_BODY" ".id"`
#TRANSACTION_SOURCE_ID=3

echo "Your transaction source is ready!"

echo 
echo '### Step 2: Create Segments'

_BODY='{ "name": "kitchen", 
 "label": "Kitchen" }' 
GAME_ID=`IC_POST /admin/segments "$_BODY" ".id"`

_BODY='{ "name": "meeting_room", 
 "label": "Meeting room" }' 
GAME_ID=`IC_POST /admin/segments "$_BODY" ".id"`

_BODY='{ "name": "restaurant", 
 "label": "Restaurant" }' 
GAME_ID=`IC_POST /admin/segments "$_BODY" ".id"`

echo "Your segments are ready!"

echo 
echo '### Step 3: Create Condition'

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "kitchen_visited_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.2",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "kitchen_left_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.2.exit",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "kitchen_visited_group_condition", 
		 "operator": "EQ", 
		 "rightSide": "6000.2.group", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_counter", 
		 "name": "kitchen_visited_first_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "1", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_counter", 
		 "name": "kitchen_visited_5_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "5", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_counter", 
		 "name": "kitchen_visited_10_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_counter", 
		 "name": "kitchen_visited_20_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "20", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_counter", 
		 "name": "kitchen_visited_50_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "50", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_group_counter", 
		 "name": "kitchen_visited_group_100_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "100", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_group_counter", 
		 "name": "kitchen_visited_group_500_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "500", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_group_counter", 
		 "name": "kitchen_visited_group_2000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "2000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "kitchen_group_counter", 
		 "name": "kitchen_visited_group_10000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "activity", 
		 "name": "login_condition",
		 "operator": "EQ", 
		 "rightSide": "login",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "login_counter", 
		 "name": "login_first_times_condition",
		 "operator": "EQ", 
		 "rightSide": "1",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "login_counter", 
		 "name": "login_5_times_condition",
		 "operator": "EQ", 
		 "rightSide": "5",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "login_counter", 
		 "name": "login_50_times_condition",
		 "operator": "EQ", 
		 "rightSide": "50",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "login_counter", 
		 "name": "login_100_times_condition",
		 "operator": "EQ", 
		 "rightSide": "100",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "login_counter", 
		 "name": "login_200_times_condition",
		 "operator": "EQ", 
		 "rightSide": "200",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "meeting_room_visited_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.3",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "meeting_room_left_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.3.exit",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "meeting_room_visited_group_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.3.group",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_counter", 
		 "name": "meeting_room_visited_first_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "1", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_counter", 
		 "name": "meeting_room_visited_5_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "5", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_counter", 
		 "name": "meeting_room_visited_10_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_counter", 
		 "name": "meeting_room_visited_20_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "20", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_counter", 
		 "name": "meeting_room_visited_50_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "50", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_group_counter", 
		 "name": "meeting_room_visited_group_100_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "100", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_group_counter", 
		 "name": "meeting_room_visited_group_500_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "500", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_group_counter", 
		 "name": "meeting_room_visited_group_2000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "2000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "meeting_room_group_counter", 
		 "name": "meeting_room_visited_group_10000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "restaurant_visited_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.4",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "restaurant_left_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.4.exit",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "restaurant_visited_group_condition",
		 "operator": "EQ", 
		 "rightSide": "6000.4.group",
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_counter", 
		 "name": "restaurant_visited_first_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "1", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_counter", 
		 "name": "restaurant_visited_5_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "5", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_counter", 
		 "name": "restaurant_visited_10_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_counter", 
		 "name": "restaurant_visited_20_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "20", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_counter", 
		 "name": "restaurant_visited_50_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "50", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_group_counter", 
		 "name": "restaurant_visited_group_100_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "100", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_group_counter", 
		 "name": "restaurant_visited_group_500_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "500", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_group_counter", 
		 "name": "restaurant_visited_group_2000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "2000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "restaurant_group_counter", 
		 "name": "restaurant_visited_group_10000_times_condition", 
		 "operator": "EQ", 
		 "rightSide": "10000", 
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"', 
		 "type": "NORMAL" }'
CONDITION_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

echo "Your conditions are ready!"

echo 
echo '### Step 4: Create Counter'

_BODY='{ "description":"Value is place ID where user currently is", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"place_id_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":1 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"1"' ], 
         "description":"Kitchen visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"kitchen_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"3"' ], 
         "description":"Kitchen group visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"kitchen_group_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"12"' ], 
         "description":"Login counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"login_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"19"' ], 
         "description":"Meeting room visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"meeting_room_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"21"' ], 
         "description":"Meeting room group visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"meeting_room_group_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"31"' ], 
         "description":"Restaurant visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"restaurant_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ '"33"' ], 
         "description":"Restaurant group visit counter", 
         "eventSettable": "true", 
         "global":"false", 
         "name":"restaurant_group_counter", 
         "requirement":"ALL", 
         "transactionSource":'"$TRANSACTION_SOURCE_ID"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

echo "Your counters are ready!"

echo 
echo '### Step 5. Create achievement '

_BODY='{ "name": "kitchen_visited_first_times_achievement", 
		 "label": "Kitchen Achievement First Times", 
		 "description": "You visited kitchen first times!", 
		 "data": { "how_to": "Visit kitchen 1 time!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_5_times_achievement", 
		 "label": "Kitchen Achievement 5 Times", 
		 "description": "You visited kitchen 5 times!", 
		 "data": { "how_to": "Visit kitchen 5 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_10_times_achievement", 
		 "label": "Kitchen Achievement 10 Times", 
		 "description": "You visited kitchen 10 times!", 
		 "data": { "how_to": "Visit kitchen 10 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_20_times_achievement", 
		 "label": "Kitchen Achievement 20 Times", 
		 "description": "You visited kitchen 20 times!", 
		 "data": { "how_to": "Visit kitchen 20 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_50_times_achievement", 
		 "label": "Kitchen Achievement 50 Times", 
		 "description": "You visited kitchen 50 times!", 
		 "data": { "how_to": "Visit kitchen 50 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_group_100_times_achievement", 
		 "label": "Kitchen Group Achievement 100 Times", 
		 "description": "Employees visited kitchen 100 times!", 
		 "data": { "how_to": "Visit kitchen 100 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_group_500_times_achievement", 
		 "label": "Kitchen Group Achievement 500 Times", 
		 "description": "Employees visited kitchen 500 times!", 
		 "data": { "how_to": "Visit kitchen 500 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_group_2000_times_achievement", 
		 "label": "Kitchen Group Achievement 2 000 Times", 
		 "description": "Employees visited kitchen 2 000 times!", 
		 "data": { "how_to": "Visit kitchen 2000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "kitchen_visited_group_10000_times_achievement", 
		 "label": "Kitchen Group Achievement 10 000 Times", 
		 "description": "Employees visited kitchen 10 000 times!", 
		 "data": { "how_to": "Visit kitchen 10 000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "login_first_times_achievement", 
		 "label": "Login Achievement First Times", 
		 "description": "Login first times!", 
		 "data": { "how_to": "Login 1 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "login_5_times_achievement", 
		 "label": "Login Achievement 5 Times", 
		 "description": "Login 5 times!", 
		 "data": { "how_to": "Login 5 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "login_50_times_achievement", 
		 "label": "Login Achievement 50 Times", 
		 "description": "Login 50 times!", 
		 "data": { "how_to": "Login 50 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "login_100_times_achievement", 
		 "label": "Login Achievement 100 Times", 
		 "description": "Login 100 times!", 
		 "data": { "how_to": "Login 100 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "login_200_times_achievement", 
		 "label": "Login Achievement 200 Times", 
		 "description": "Login 200 times!", 
		 "data": { "how_to": "Login 200 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_first_times_achievement", 
		 "label": "Meeting Room Achievement First Times", 
		 "description": "You visited meeting room first times!", 
		 "data": { "how_to": "Visit meeting room 1 time!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_5_times_achievement", 
		 "label": "Meeting Room Achievement 5 Times", 
		 "description": "You visited meeting room 5 times!", 
		 "data": { "how_to": "Visit meeting room 5 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_10_times_achievement", 
		 "label": "Meeting Room Achievement 10 Times", 
		 "description": "You visited meeting room 10 times!", 
		 "data": { "how_to": "Visit meeting room 10 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_20_times_achievement", 
		 "label": "Meeting Room Achievement 20 Times", 
		 "description": "You visited meeting room 20 times!", 
		 "data": { "how_to": "Visit meeting room 20 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_50_times_achievement", 
		 "label": "Meeting Room Achievement 50 Times", 
		 "description": "You visited meeting room 50 times!", 
		 "data": { "how_to": "Visit meeting room 50 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_group_100_times_achievement", 
		 "label": "Meeting Room Group Achievement 100 Times", 
		 "description": "Employees visited meeting room 100 times!", 
		 "data": { "how_to": "Visit meeting room 100 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_group_500_times_achievement", 
		 "label": "Meeting Room Group Achievement 500 Times", 
		 "description": "Employees visited meeting room 500 times!", 
		 "data": { "how_to": "Visit meeting room 500 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_group_2000_times_achievement", 
		 "label": "Meeting Room Group Achievement 2 000 Times", 
		 "description": "Employees visited meeting room 2 000 times!", 
		 "data": { "how_to": "Visit meeting room 2000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "meeting_room_visited_group_10000_times_achievement", 
		 "label": "Meeting Room Group Achievement 10 000 Times", 
		 "description": "Employees visited meeting room 10 000 times!", 
		 "data": { "how_to": "Visit meeting room 10 000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`


_BODY='{ "name": "restaurant_visited_first_times_achievement", 
		 "label": "Restaurant Achievement First Times", 
		 "description": "You visited restaurant first times!", 
		 "data": { "how_to": "Visit restaurant 1 time!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_5_times_achievement", 
		 "label": "Restaurant Achievement 5 Times", 
		 "description": "You visited restaurant 5 times!", 
		 "data": { "how_to": "Visit restaurant 5 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_10_times_achievement", 
		 "label": "Restaurant Achievement 10 Times", 
		 "description": "You visited restaurant 10 times!", 
		 "data": { "how_to": "Visit restaurant 10 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_20_times_achievement", 
		 "label": "Restaurant Achievement 20 Times", 
		 "description": "You visited restaurant 20 times!", 
		 "data": { "how_to": "Visit restaurant 20 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_50_times_achievement", 
		 "label": "Restaurant Achievement 50 Times", 
		 "description": "You visited restaurant 50 times!", 
		 "data": { "how_to": "Visit restaurant 50 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_group_100_times_achievement", 
		 "label": "Restaurant Group Achievement 100 Times", 
		 "description": "Employees visited restaurant 100 times!", 
		 "data": { "how_to": "Visit restaurant 100 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_group_500_times_achievement", 
		 "label": "Restaurant Group Achievement 500 Times", 
		 "description": "Employees visited restaurant 500 times!", 
		 "data": { "how_to": "Visit restaurant 500 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_group_2000_times_achievement", 
		 "label": "Kitchen Group Achievement 2 000 Times", 
		 "description": "Employees visited kitchen 2 000 times!", 
		 "data": { "how_to": "Visit kitchen 2000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "restaurant_visited_group_10000_times_achievement", 
		 "label": "Restaurant Group Achievement 10 000 Times", 
		 "description": "Employees visited restaurant 10 000 times!", 
		 "data": { "how_to": "Visit restaurant 10 000 times!" } }'
ACHIEVEMENT_LOGIN_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

echo "Your achievements are ready!"

echo
echo '### Step 6: Create Notification Type '

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "global_notifications", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "ACHIEVEMENT", 
		 "config": null, 
		 "name": "achievement_notification", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "COUNTER_MODIFY", 
		 "config": null, 
		 "name": "counter_notification", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "kitchen", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "meeting_room", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "restaurant", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "pebble_notification", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "mobile_notification", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`

echo "Your notification types are ready!"

echo
echo '### Step 7: Create Notification'

_BODY='{ "data": { 
				"counterId":'"1"',"value":"{set}1"
			}, 
		 "notificationType": '"3"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"counterId":'"1"',"value":"{set}2"
			}, 
		 "notificationType": '"3"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"counterId":'"1"',"value":"{set}3"
			}, 
		 "notificationType": '"3"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"counterId":'"1"',"value":"{set}4"
			}, 
		 "notificationType": '"3"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

for i in `seq 1 32`
do
_BODY='{ "data": { 
				"achievementId": '"$i"' 
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`
done

_BODY='{ "data": { 
				"body":{"message":"just entered the kitchen!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the kitchen!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the kitchen!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the kitchen!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the meeting room!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the meeting room!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the meeting room!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the meeting room!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the restaurant!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the restaurant!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the restaurant!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the restaurant!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"KITCHEN VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"4"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 100 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 100 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 100 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 200 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 200 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 200 TIME LOGIN achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES KITCHEN VISIT achievement!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES MEETING ROOM VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"MEETING ROOM VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"5"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned FIRST TIME RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 TIMES RESTAURANT VISIT achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 100 TIMES!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 500 TIMES!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 2 000 TIMES!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"RESTAURANT VISITED 10 000 TIMES!"}
			}, 
		 "notificationType": '"6"' }'
NOTIFICATION_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

echo "Your notifications are ready!"

echo 
echo '### Step 8: Create Game'

_BODY='{ "active": true, 
		 "conditions": ['"1"'], 
		 "expression": "{'"1"'}",
 "segments": ['"1"'], 
		 "gameType": "GRADUAL",
		 "name": "kitchen_visited_game",
		 "notifications": ['"2"', '"37"', '"38"', '"39"', '"40"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"2"'], 
		 "expression": "{'"2"'}",
		 "gameType": "GRADUAL",
		 "name": "kitchen_left_game",
		 "notifications": ['"1"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"3"'], 
		 "expression": "{'"3"'}",
		 "gameType": "GRADUAL",
		 "name": "kitchen_visited_group_game",
		 "notifications": [],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"4"'], 
		 "expression": "{'"4"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_first_times_game",
		 "notifications": ['"5"', '"49"', '"50"', '"51"', '"52"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"5"'], 
		 "expression": "{'"5"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_5_times_game",
		 "notifications": ['"6"', '"53"', '"54"', '"55"', '"56"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"6"'], 
		 "expression": "{'"6"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_10_times_game",
		 "notifications": ['"7"', '"57"', '"58"', '"59"', '"60"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"7"'], 
		 "expression": "{'"7"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_20_times_game",
		 "notifications": ['"8"', '"61"', '"62"', '"63"', '"64"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"8"'], 
		 "expression": "{'"8"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_50_times_game",
		 "notifications": ['"9"', '"65"', '"66"', '"67"', '"68"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"9"'],
		 "expression": "{'"9"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_100_times_game",
		 "notifications": ['"10"', '"69"', '"70"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"10"'], 
		 "expression": "{'"10"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_500_times_game",
		 "notifications": ['"11"', '"71"', '"72"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"11"'], 
		 "expression": "{'"11"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_2000_times_game",
		 "notifications": ['"12"', '"73"', '"74"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"12"'], 
		 "expression": "{'"12"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_10000_times_game",
		 "notifications": ['"13"', '"75"', '"76"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"13"'], 
		 "expression": "{'"13"'}",
		 "gameType": "GRADUAL",
		 "name": "login_game",
		 "notifications": ['"1"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"14"'], 
		 "expression": "{'"14"'}",
		 "gameType": "ONE_TIME",
		 "name": "Login_first_times_game",
		 "notifications": ['"14"', '"77"', '"78"', '"79"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"15"'], 
		 "expression": "{'"15"'}",
		 "gameType": "ONE_TIME",
		 "name": "Login_5_times_game",
		 "notifications": ['"15"', '"80"', '"81"', '"82"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"16"'], 
		 "expression": "{'"16"'}",
		 "gameType": "ONE_TIME",
		 "name": "Login_50_times_game",
		 "notifications": ['"16"', '"83"', '"84"', '"85"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"17"'], 
		 "expression": "{'"17"'}",
		 "gameType": "ONE_TIME",
		 "name": "Login_100_times_game",
		 "notifications": ['"17"', '"86"', '"87"', '"88"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"18"'], 
		 "expression": "{'"18"'}",
		 "gameType": "ONE_TIME",
		 "name": "Login_200_times_game",
		 "notifications": ['"18"', '"89"', '"90"', '"91"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"19"'], 
		 "expression": "{'"19"'}",
 "segments": ['"2"'], 
		 "gameType": "GRADUAL",
		 "name": "meeting_room_visited_game",
		 "notifications": ['"3"', '"41"', '"42"', '"43"', '"44"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"20"'], 
		 "expression": "{'"20"'}",
		 "gameType": "GRADUAL",
		 "name": "meeting_room_left_game",
		 "notifications": ['"1"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"21"'], 
		 "expression": "{'"21"'}",
		 "gameType": "GRADUAL",
		 "name": "meeting_room_visited_group_game",
		 "notifications": [],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"22"'], 
		 "expression": "{'"22"'}",
		 "gameType": "ONE_TIME",
		 "name": "meeting_room_visited_first_times_game",
		 "notifications": ['"19"', '"92"', '"93"', '"94"', '"95"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"23"'], 
		 "expression": "{'"23"'}",
		 "gameType": "ONE_TIME",
		 "name": "meeting_room_visited_5_times_game",
		 "notifications": ['"20"', '"96"', '"97"', '"98"', '"99"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"24"'], 
		 "expression": "{'"24"'}",
		 "gameType": "ONE_TIME",
		 "name": "meeting_room_visited_10_times_game",
		 "notifications": ['"21"', '"100"', '"101"', '"102"', '"103"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"25"'], 
		 "expression": "{'"25"'}",
		 "gameType": "ONE_TIME",
		 "name": "meeting_room_visited_20_times_game",
		 "notifications": ['"22"', '"104"', '"105"', '"106"', '"107"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"26"'], 
		 "expression": "{'"26"'}",
		 "gameType": "ONE_TIME",
		 "name": "meeting_room_visited_50_times_game",
		 "notifications": ['"23"', '"108"', '"109"', '"110"', '"111"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"27"'], 
		 "expression": "{'"27"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_100_times_game",
		 "notifications": ['"24"', '"112"', '"113"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"28"'], 
		 "expression": "{'"28"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_500_times_game",
		 "notifications": ['"25"', '"114"', '"115"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"29"'], 
		 "expression": "{'"29"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_2000_times_game",
		 "notifications": ['"26"', '"116"', '"117"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"30"'], 
		 "expression": "{'"30"'}",
		 "gameType": "ONE_TIME",
		 "name": "kitchen_visited_group_10000_times_game",
		 "notifications": ['"27"', '"118"', '"119"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"31"'], 
		 "expression": "{'"31"'}",
 "segments": ['"3"'], 
		 "gameType": "GRADUAL",
		 "name": "restaurant_visited_game",
		 "notifications": ['"4"', '"45"', '"46"', '"47"', '"48"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"32"'], 
		 "expression": "{'"32"'}",
		 "gameType": "GRADUAL",
		 "name": "restaurant_left_game",
		 "notifications": ['"1"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"33"'], 
		 "expression": "{'"33"'}",
		 "gameType": "GRADUAL",
		 "name": "restaurant_visited_group_game",
		 "notifications": [],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"34"'], 
		 "expression": "{'"34"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_first_times_game",
		 "notifications": ['"28"', '"120"', '"121"', '"122"', '"123"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"35"'], 
		 "expression": "{'"35"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_5_times_game",
		 "notifications": ['"29"', '"124"', '"125"', '"126"', '"127"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ['"36"'], 
		 "expression": "{'"36"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_10_times_game",
		 "notifications": ['"30"', '"128"', '"129"', '"130"', '"131"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"37"'], 
		 "expression": "{'"37"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_20_times_game",
		 "notifications": ['"31"', '"132"', '"133"', '"134"', '"135"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"38"'], 
		 "expression": "{'"38"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_50_times_game",
		 "notifications": ['"32"', '"136"', '"137"', '"138"', '"139"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"39"'],
		 "expression": "{'"39"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_group_100_times_game",
		 "notifications": ['"33"', '"140"', '"141"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"40"'], 
		 "expression": "{'"40"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_group_500_times_game",
		 "notifications": ['"34"', '"142"', '"143"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"41"'], 
		 "expression": "{'"41"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_group_2000_times_game",
		 "notifications": ['"35"', '"144"', '"145"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ['"42"'], 
		 "expression": "{'"42"'}",
		 "gameType": "ONE_TIME",
		 "name": "restaurant_visited_group_10000_times_game",
		 "notifications": ['"36"', '"146"', '"147"'],
		 "transactionSource": '"$TRANSACTION_SOURCE_ID"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

echo "Your games are ready!"

echo 
echo '### Step 9: Create User Groups'

_BODY='{ "name": "no_room", 
		 "label": "Not in a room" }' 
GAME_ID=`IC_POST /admin/users/groups "$_BODY" ".id"`

_BODY='{ "name": "kitchen", 
 "segments": ['"1"'], 
		 "label": "Kitchen" }' 
GAME_ID=`IC_POST /admin/users/groups "$_BODY" ".id"`

_BODY='{ "name": "meeting_room", 
 "segments": ['"2"'], 
		 "label": "Meeting room" }' 
GAME_ID=`IC_POST /admin/users/groups "$_BODY" ".id"`

_BODY='{ "name": "restaurant", 
		 "segments": ['"3"'], 
		 "label": "Restaurant" }' 
GAME_ID=`IC_POST /admin/users/groups "$_BODY" ".id"`

echo "Your user groups are ready!"

echo 
echo '### Step 10: Create Client scripts'

_BODY='{ "name": "LeaderboardPointsScript", 
		 "code": "return $.subject.getCounterValue(2)+$.subject.getCounterValue(4)+$.subject.getCounterValue(5)+$.subject.getCounterValue(7);",
 "returnType": "NUMBER" }' 
GAME_ID=`IC_POST /admin/clientscripts "$_BODY" ".id"`

echo "Your client scripts are ready!"

echo 
echo '### Step 11: Create Leaderboards'

_BODY='{ "active": "true",
 "name": "UsersLeaderboard", 
 "description": "Leaderboard that contains all users points",
 "cron": "0 45 * * * *",
		 "script": '"1"' }' 
GAME_ID=`IC_POST /admin/leaderboards "$_BODY" ".id"`

echo "Your leaderboards are ready!"

echo 
echo '### Step 12: Create Users'

_BODY='{ "email": "'$2'",
 "status": "ACTIVE", 
		 "level": '"1"' }' 
GAME_ID=`IC_POST /admin/users "$_BODY" ".id"`

echo "Your users are ready!"

echo
echo "End"

