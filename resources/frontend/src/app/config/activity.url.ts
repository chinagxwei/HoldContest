import {API_MODULE, API_VERSION, HOST} from "./config";

/**
 * 任务列表
 */
export const QUEST_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/quest/index`;

/**
 * 保存任务
 */
export const QUEST_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/quest/save`;

/**
 * 任务详情
 */
export const QUEST_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/quest/view`;

/**
 * 任务删除
 */
export const QUEST_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/quest/delete`;

/**
 * 抽奖项列表
 */
export const LUCKY_DRAWS_ITEM_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-item/index`;

/**
 * 保存抽奖项
 */
export const LUCKY_DRAWS_ITEM_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-item/save`;

/**
 * 抽奖项详情
 */
export const LUCKY_DRAWS_ITEM_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-item/view`;

/**
 * 抽奖项删除
 */
export const LUCKY_DRAWS_ITEM_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-item/delete`;

/**
 * 抽奖配置列表
 */
export const LUCKY_DRAWS_CONFIG_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-config/index`;

/**
 * 保存抽奖配置
 */
export const LUCKY_DRAWS_CONFIG_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-config/save`;

/**
 * 抽奖配置详情
 */
export const LUCKY_DRAWS_CONFIG_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-config/view`;

/**
 * 抽奖配置删除
 */
export const LUCKY_DRAWS_CONFIG_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/lucky-draws-config/delete`;
