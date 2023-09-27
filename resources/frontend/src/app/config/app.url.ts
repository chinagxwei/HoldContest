import {API_MODULE, API_VERSION, HOST} from "./config";


/**
 * app问题列表
 */
export const APP_BUG_LOG_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-bug-log/index`;

/**
 * app问题保存
 */
export const APP_BUG_LOG_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-bug-log/save`;

/**
 * app问题详情
 */
export const APP_BUG_LOG_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-bug-log/view`;

/**
 * app问题删除
 */
export const APP_BUG_LOG_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-bug-log/delete`;


/**
 * app发布列表
 */
export const APP_PUBLISH_LOG_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-publish-log/index`;

/**
 * app发布保存
 */
export const APP_PUBLISH_LOG_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-publish-log/save`;

/**
 * app发布详情
 */
export const APP_PUBLISH_LOG_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-publish-log/view`;

/**
 * app发布删除
 */
export const APP_PUBLISH_LOG_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/app-publish-log/delete`;
