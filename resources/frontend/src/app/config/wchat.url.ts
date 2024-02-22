import {API_MODULE, API_VERSION, HOST} from "./config";

/**
 * 微信小程序会员列表
 */
export const WECHAT_MINI_PROGRAM_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-mini-program/index`;

/**
 * 微信小程序会员详情
 */
export const WECHAT_MINI_PROGRAM_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-mini-program/view`;


/**
 * 删除微信小程序会员
 */
export const WECHAT_MINI_PROGRAM_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-mini-program/delete`;

/**
 * 微信公众号会员列表
 */
export const WECHAT_OFFICE_ACCOUNT_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-office-account/index`;

/**
 * 微信公众号会员详情
 */
export const WECHAT_OFFICE_ACCOUNT_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-office-account/view`;


/**
 * 删除微信公众号会员
 */
export const WECHAT_OFFICE_ACCOUNT_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/wechat-office-account/delete`;



