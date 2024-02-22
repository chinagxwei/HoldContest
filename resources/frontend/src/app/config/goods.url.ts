import {API_MODULE, API_VERSION, HOST} from "./config";

/**
 * 商品列表
 */
export const GOODS_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/goods/index`;

/**
 * 保存商品
 */
export const GOODS_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/goods/save`;

/**
 * 商品详情
 */
export const GOODS_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/goods/view`;

/**
 * 删除商品
 */
export const GOODS_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/goods/delete`;

/**
 * 充值产品列表
 */
export const PRODUCT_RECHARGE_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-recharge/index`;

/**
 * 保存充值产品
 */
export const PRODUCT_RECHARGE_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-recharge/save`;

/**
 * 充值产品详情
 */
export const PRODUCT_RECHARGE_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-recharge/view`;

/**
 * 删除充值产品
 */
export const PRODUCT_RECHARGE_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-recharge/delete`;

/**
 * VIP产品列表
 */
export const PRODUCT_VIP_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-vip/index`;

/**
 * 保存VIP产品
 */
export const PRODUCT_VIP_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-vip/save`;

/**
 * VIP产品详情
 */
export const PRODUCT_VIP_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-vip/view`;

/**
 * 删除VIP产品
 */
export const PRODUCT_VIP_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/product-vip/delete`;
