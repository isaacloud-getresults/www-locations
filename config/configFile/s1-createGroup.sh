#!/bin/bash
## Init
set -e
cd "$(dirname "$0")"
. ../tools/init 

echo "### Step 0: IsaaCloud authentication"
GET_TOKEN $1

echo 
echo '### Step 1: Create Segment'
_BODY='{ "name": "'$3'", 
 "label": "'$2'" }' 
SEG_1_ID=`IC_POST /admin/segments "$_BODY" ".id"`

_BODY='{ "name": "'$3'_exit", 
 "label": "'$2' Exit" }' 
SEG_2_ID=`IC_POST /admin/segments "$_BODY" ".id"`

_BODY='{ "name": "'$3'_group", 
 "label": "'$2' Group" }' 
SEG_3_ID=`IC_POST /admin/segments "$_BODY" ".id"`
echo "Your segments are ready!"

echo 
echo '### Step 2: Create User Group'
_BODY='{ "name": "'$3'", 
 "segments": ["'$SEG_1_ID'", "'$SEG_2_ID'", "'$SEG_3_ID'"], 
		 "label": "'$2'" }' 
GROUP_ID=`IC_POST /admin/users/groups "$_BODY" ".id"`
echo "Your user group is ready!"

echo
echo '### Step 3: Create Notification Type '
_BODY='{ "action": "CUSTOM", 
		 "config": null, 
		 "name": "'$3'", 
		 "priority": "PRIORITY_MEDIUM" }'
NOTIFICATION_TYPE_ID=`IC_POST /admin/notifications/types "$_BODY" ".id"`
echo "Your notification type is ready!"

echo 
echo '### Step 4: Create Condition'
_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "'$3'_visited_condition",
		 "operator": "EQ", 
		 "rightSide": "0.0",
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_ENTER_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "'$3'_exit_condition",
		 "operator": "EQ", 
		 "rightSide": "0.0.exit",
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_EXIT_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "place", 
		 "name": "'$3'_visited_group_condition", 
		 "operator": "EQ", 
		 "rightSide": "0.0.group", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_GROUP_ENTER_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_counter", 
		 "name": "'$3'_visit_1t_cond", 
		 "operator": "EQ", 
		 "rightSide": "1", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_1_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_counter", 
		 "name": "'$3'_visit_5t_cond", 
		 "operator": "EQ", 
		 "rightSide": "5", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_2_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_counter", 
		 "name": "'$3'_visit_10t_cond", 
		 "operator": "EQ", 
		 "rightSide": "10", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_3_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_counter", 
		 "name": "'$3'_visit_20t_cond", 
		 "operator": "EQ", 
		 "rightSide": "20", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_4_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_counter", 
		 "name": "'$3'_visit_50t_cond", 
		 "operator": "EQ", 
		 "rightSide": "50", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_5_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_group_counter", 
		 "name": "'$3'_visit_group_100t_cond", 
		 "operator": "EQ", 
		 "rightSide": "100", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_6_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_group_counter", 
		 "name": "'$3'_visit_group_500t_cond", 
		 "operator": "EQ", 
		 "rightSide": "500", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_7_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_group_counter", 
		 "name": "'$3'_visit_group_2000t_cond", 
		 "operator": "EQ", 
		 "rightSide": "2000", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_8_ID=`IC_POST /admin/conditions "$_BODY" ".id"`

_BODY='{ "counters": [], 
		 "leftSide": "'$3'_group_counter", 
		 "name": "'$3'_visit_group_10000t_cond", 
		 "operator": "EQ", 
		 "rightSide": "10000", 
		 "transactionSource": '"1"', 
		 "type": "NORMAL" }'
CONDITION_9_ID=`IC_POST /admin/conditions "$_BODY" ".id"`
echo "Your conditions are ready!"

echo 
echo '### Step 5: Create Counter'
_BODY='{ "conditions":[ "'$CONDITION_ENTER_ID'" ], 
         "eventSettable": "true", 
         "global":"false", 
         "name":"'$3'_counter", 
         "requirement":"ALL", 
         "transactionSource":'"1"' , 
         "value":0 }'
COUNTER_ID=`IC_POST /admin/counters "$_BODY" ".id"` 

_BODY='{ "conditions":[ "'$CONDITION_GROUP_ENTER_ID'" ], 
         "eventSettable": "true", 
         "global":"false", 
         "name":"'$3'_group_counter", 
         "requirement":"ALL", 
         "transactionSource":'"1"' , 
         "value":0 }'
COUNTER_GROUP_ID=`IC_POST /admin/counters "$_BODY" ".id"` 
echo "Your counters are ready!"

echo 
echo '### Step 6. Create achievement '
_BODY='{ "name": "'$3'_visit_1t_achiev", 
		 "label": "'$2' 1st Visit", 
		 "description": "You visited '$2' first times!", 
		 "data": { "how_to": "Visit '$2' 1 time!" } }'
ACHIEVEMENT_1_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_5t_achiev", 
		 "label": "'$2' 5th Visit", 
		 "description": "You visited '$2' 5 times!", 
		 "data": { "how_to": "Visit '$2' 5 times!" } }'
ACHIEVEMENT_2_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_10t_achiev", 
		 "label": "'$2' 10th Visit", 
		 "description": "You visited '$2' 10 times!", 
		 "data": { "how_to": "Visit '$2' 10 times!" } }'
ACHIEVEMENT_3_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_20t_achiev", 
		 "label": "'$2' 20th Visit", 
		 "description": "You visited '$2' 20 times!", 
		 "data": { "how_to": "Visit '$2' 20 times!" } }'
ACHIEVEMENT_4_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_50t_achiev", 
		 "label": "'$2' 50th Visit", 
		 "description": "You visited '$2' 50 times!", 
		 "data": { "how_to": "Visit '$2' 50 times!" } }'
ACHIEVEMENT_5_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_group_100t_achiev", 
		 "label": "'$2' Group 100th Visit", 
		 "description": "Employees visited '$2' 100 times!", 
		 "data": { "how_to": "Visit '$2' 100 times!" } }'
ACHIEVEMENT_6_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_group_500t_achiev", 
		 "label": "'$2' Group 500th Visit", 
		 "description": "Employees visited '$2' 500 times!", 
		 "data": { "how_to": "Visit '$2' 500 times!" } }'
ACHIEVEMENT_7_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_group_2000t_achiev", 
		 "label": "'$2' Group 2 000th Visit", 
		 "description": "Employees visited '$2' 2 000 times!", 
		 "data": { "how_to": "Visit '$2' 2000 times!" } }'
ACHIEVEMENT_8_ID=`IC_POST /admin/achievements "$_BODY" ".id"`

_BODY='{ "name": "'$3'_visit_group_10000t_achiev", 
		 "label": "'$2' Group 10 000th Visit", 
		 "description": "Employees visited '$2' 10 000 times!", 
		 "data": { "how_to": "Visit '$2' 10 000 times!" } }'
ACHIEVEMENT_9_ID=`IC_POST /admin/achievements "$_BODY" ".id"`
echo "Your achievements are ready!"

echo
echo '### Step 7: Create Notification'
_BODY='{ "data": { 
				"counterId":'"1"',"value":"{set}'$GROUP_ID'"
			}, 
		 "notificationType": '"3"' }'
NOTIFICATION_ENTER_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_1_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A1_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_2_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A2_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_3_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A3_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_4_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A4_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_5_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A5_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_6_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A6_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_7_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A7_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_8_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A8_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"achievementId": "'$ACHIEVEMENT_9_ID'"
			}, 
		 "notificationType": '"2"' }'
NOTIFICATION_A9_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the '$2'!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_E1_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the '$2'!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_E2_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the '$2'!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_E3_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just entered the '$2'!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_E4_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned first time '$2' visit achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG1_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned first time '$2' visit achievement!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG2_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned first time '$2' visit achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_AG3_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned first time '$2' visit achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_AG4_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG5_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG6_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_AG7_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 5 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_AG8_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG9_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG10_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_AG11_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 10 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_AG12_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG13_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG14_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_AG15_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 20 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_AG16_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG17_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"'}'
NOTIFICATION_AG18_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"7"' }'
NOTIFICATION_AG19_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"just earned 50 times '$2' visit achievement!"}
			}, 
		 "notificationType": '"8"' }'
NOTIFICATION_AG20_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 100 times!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG21_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 100 times!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG22_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 500 times!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG23_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 500 times!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG24_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 2 000 times!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG25_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 2 000 times!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG26_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 10 000 times!"}
			}, 
		 "notificationType": '"1"' }'
NOTIFICATION_AG27_ID=`IC_POST /admin/notifications "$_BODY" ".id"`

_BODY='{ "data": { 
				"body":{"message":"'$2' visited 10 000 times!"}
			}, 
		 "notificationType": '"$NOTIFICATION_TYPE_ID"' }'
NOTIFICATION_AG28_ID=`IC_POST /admin/notifications "$_BODY" ".id"`
echo "Your notifications are ready!"

echo 
echo '### Step 8: Create Game'
_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_ENTER_ID'"], 
		 "expression": "{'"$CONDITION_ENTER_ID"'}",
 "segments": ["'$SEG_1_ID'"], 
		 "gameType": "GRADUAL",
		 "name": "'$3'_visited_game",
		 "notifications": ["'$NOTIFICATION_ENTER_ID'", "'$NOTIFICATION_E1_ID'", "'$NOTIFICATION_E2_ID'", "'$NOTIFICATION_E3_ID'", "'$NOTIFICATION_E4_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_EXIT_ID'"], 
		 "expression": "{'"$CONDITION_EXIT_ID"'}",
"segments": ["'$SEG_2_ID'"], 
		 "gameType": "GRADUAL",
		 "name": "'$3'_left_game",
		 "notifications": ['"1"'],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_GROUP_ENTER_ID'"], 
		 "expression": "{'"$CONDITION_GROUP_ENTER_ID"'}",
"segments": ["'$SEG_3_ID'"], 
		 "gameType": "GRADUAL",
		 "name": "'$3'_visited_group_game",
		 "notifications": [],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_1_ID'"], 
		 "expression": "{'"$CONDITION_1_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_1t_game",
		 "notifications": ["'$NOTIFICATION_A1_ID'", "'$NOTIFICATION_AG1_ID'", "'$NOTIFICATION_AG2_ID'", "'$NOTIFICATION_AG3_ID'", "'$NOTIFICATION_AG4_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_2_ID'"], 
		 "expression": "{'"$CONDITION_2_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_5t_game",
		 "notifications": ["'$NOTIFICATION_A2_ID'", "'$NOTIFICATION_AG5_ID'", "'$NOTIFICATION_AG6_ID'", "'$NOTIFICATION_AG7_ID'", "'$NOTIFICATION_AG8_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"` 

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_3_ID'"], 
		 "expression": "{'"$CONDITION_3_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_10t_game",
		 "notifications": ["'$NOTIFICATION_A3_ID'", "'$NOTIFICATION_AG9_ID'", "'$NOTIFICATION_AG10_ID'", "'$NOTIFICATION_AG11_ID'", "'$NOTIFICATION_AG12_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_4_ID'"], 
		 "expression": "{'"$CONDITION_4_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_20t_game",
		 "notifications": ["'$NOTIFICATION_A4_ID'", "'$NOTIFICATION_AG13_ID'", "'$NOTIFICATION_AG14_ID'", "'$NOTIFICATION_AG15_ID'", "'$NOTIFICATION_AG16_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_5_ID'"], 
		 "expression": "{'"$CONDITION_5_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_50t_game",
		 "notifications": ["'$NOTIFICATION_A5_ID'", "'$NOTIFICATION_AG17_ID'", "'$NOTIFICATION_AG18_ID'", "'$NOTIFICATION_AG19_ID'", "'$NOTIFICATION_AG20_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_6_ID'"], 
		 "expression": "{'"$CONDITION_6_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_group_100t_game",
		 "notifications": ["'$NOTIFICATION_A6_ID'", "'$NOTIFICATION_AG21_ID'", "'$NOTIFICATION_AG22_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_7_ID'"], 
		 "expression": "{'"$CONDITION_7_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_group_500t_game",
		 "notifications": ["'$NOTIFICATION_A7_ID'", "'$NOTIFICATION_AG23_ID'", "'$NOTIFICATION_AG24_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_8_ID'"], 
		 "expression": "{'"$CONDITION_8_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_group_2000t_game",
		 "notifications": ["'$NOTIFICATION_A8_ID'", "'$NOTIFICATION_AG25_ID'", "'$NOTIFICATION_AG26_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`

_BODY='{ "active": true, 
		 "conditions": ["'$CONDITION_9_ID'"], 
		 "expression": "{'"$CONDITION_9_ID"'}",
		 "gameType": "ONE_TIME",
		 "name": "'$3'_visit_group_10000t_game",
		 "notifications": ["'$NOTIFICATION_A9_ID'", "'$NOTIFICATION_AG27_ID'", "'$NOTIFICATION_AG28_ID'"],
		 "transactionSource": '"1"' }' 
GAME_ID=`IC_POST /admin/games "$_BODY" ".id"`
echo "Your games are ready!"
echo
echo "End"
