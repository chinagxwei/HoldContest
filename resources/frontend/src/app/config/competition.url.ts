import {API_VERSION, HOST} from "./config";


/**
 * 比赛游戏列表
 */
export const COMPETITION_GAME_LIST = `${HOST}/api/${API_VERSION}/competition-game/index`;

/**
 * 保存比赛游戏
 */
export const COMPETITION_GAME_SAVE = `${HOST}/api/${API_VERSION}/competition-game/save`;

/**
 * 比赛游戏详情
 */
export const COMPETITION_GAME_VIEW = `${HOST}/api/${API_VERSION}/competition-game/view`;

/**
 * 删除比赛游戏
 */
export const COMPETITION_GAME_DELETE = `${HOST}/api/${API_VERSION}/competition-game/delete`;

/**
 * 游戏团队列表
 */
export const COMPETITION_GAME_TEAM_LIST = `${HOST}/api/${API_VERSION}/competition-game-team/index`;

/**
 * 保存游戏团队
 */
export const COMPETITION_GAME_TEAM_SAVE = `${HOST}/api/${API_VERSION}/competition-game-team/save`;

/**
 * 游戏团队详情
 */
export const COMPETITION_GAME_TEAM_VIEW = `${HOST}/api/${API_VERSION}/competition-game-team/view`;

/**
 * 删除游戏团队
 */
export const COMPETITION_GAME_TEAM_DELETE = `${HOST}/api/${API_VERSION}/competition-game-team/delete`;

/**
 * 游戏房间列表
 */
export const COMPETITION_GAME_ROOM_LIST = `${HOST}/api/${API_VERSION}/competition-room/index`;

/**
 * 保存游戏房间
 */
export const COMPETITION_GAME_ROOM_SAVE = `${HOST}/api/${API_VERSION}/competition-room/save`;

/**
 * 游戏房间详情
 */
export const COMPETITION_GAME_ROOM_VIEW = `${HOST}/api/${API_VERSION}/competition-room/view`;

/**
 * 删除游戏房间
 */
export const COMPETITION_GAME_ROOM_DELETE = `${HOST}/api/${API_VERSION}/competition-room/delete`;
