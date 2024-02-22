import {API_MODULE, API_VERSION, HOST} from "./config";

/**
 * 会员生成
 */
export const MEMBER_GENERATE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/generate`;

/**
 * 会员列表
 */
export const MEMBER_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/index`;

/**
 * 保存会员
 */
export const MEMBER_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/save`;

/**
 * 会员详情
 */
export const MEMBER_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/view`;

/**
 * 删除会员
 */
export const MEMBER_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/delete`;

/**
 * 设置充值
 */
export const MEMBER_SET_RECHARGE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/setRecharge`;

/**
 * 设置VIP
 */
export const MEMBER_SET_VIP = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/setVIP`;

/**
 * 设置游戏账户
 */
export const MEMBER_SET_GAME_ACCOUNT = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/setGameAccount`;

/**
 * 设置提款账户
 */
export const MEMBER_SET_WITHDRAW_ACCOUNT = `${HOST}/api/${API_VERSION}/${API_MODULE}/member/setWithdrawAccount`;

/**
 * 会员地址列表
 */
export const MEMBER_ADDRESS_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-address/index`;

/**
 * 保存会员地址
 */
export const MEMBER_ADDRESS_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-address/save`;

/**
 * 会员地址详情
 */
export const MEMBER_ADDRESS_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-address/view`;

/**
 * 删除会员地址
 */
export const MEMBER_ADDRESS_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-address/delete`;

/**
 * 会员禁封列表
 */
export const MEMBER_BAN_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-ban/index`;

/**
 * 保存会员禁封
 */
export const MEMBER_BAN_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-ban/save`;

/**
 * 会员禁封详情
 */
export const MEMBER_BAN_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-ban/view`;

/**
 * 删除会员禁封
 */
export const MEMBER_BAN_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-ban/delete`;


/**
 * 会员消息列表
 */
export const MEMBER_MESSAGE_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-message/index`;

/**
 * 保存会员消息
 */
export const MEMBER_MESSAGE_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-message/save`;

/**
 * 会员消息详情
 */
export const MEMBER_MESSAGE_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-message/view`;

/**
 * 删除会员消息
 */
export const MEMBER_MESSAGE_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/member-message/delete`;

/**
 * 称号列表
 */
export const TITLE_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/title/index`;

/**
 * 保存称号
 */
export const TITLE_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/title/save`;

/**
 * 称号详情
 */
export const TITLE_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/title/view`;

/**
 * 删除称号
 */
export const TITLE_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/title/delete`;
