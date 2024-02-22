import {API_MODULE, API_VERSION, HOST} from "./config";


/**
 * 订单列表
 */
export const ORDER_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/order/index`;

/**
 * 保存订单
 */
export const ORDER_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order/save`;

/**
 * 订单详情
 */
export const ORDER_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/order/view`;

/**
 * 删除订单
 */
export const ORDER_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order/delete`;

/**
 * 订单收益列表
 */
export const ORDER_INCOME_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income/index`;

/**
 * 保存订单收益
 */
export const ORDER_INCOME_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income/save`;

/**
 * 订单收益详情
 */
export const ORDER_INCOME_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income/view`;

/**
 * 删除订单收益
 */
export const ORDER_INCOME_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income/delete`;

/**
 * 订单收益配置列表
 */
export const ORDER_INCOME_CONFIG_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income-config/index`;

/**
 * 保存订单收益配置
 */
export const ORDER_INCOME_CONFIG_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income-config/save`;

/**
 * 订单收益配置详情
 */
export const ORDER_INCOME_CONFIG_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income-config/view`;

/**
 * 删除订单收益配置
 */
export const ORDER_INCOME_CONFIG_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/order-income-config/delete`;
