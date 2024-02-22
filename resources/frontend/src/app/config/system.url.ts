import {API_MODULE, API_VERSION, HOST} from "./config";


/**
 * 用户登录
 */
export const USER_LOGIN = `${HOST}/api/${API_VERSION}/auth/login`;
/**
 * 用户登出
 */
export const USER_LOGOUT = `${HOST}/api/${API_VERSION}/auth/logout`;
/**
 * 修改密码
 */
export const USER_RESET_PASSWORD = `${HOST}/api/${API_VERSION}/auth/reset-password`;

/**
 * 用户信息
 */
export const USER_SIMPLE_INFO = `${HOST}/api/${API_VERSION}/auth/info`;

/**
 * 管理员行为日志
 */
export const ADMIN_ACTION_LOG = `${HOST}/api/${API_VERSION}/${API_MODULE}/log/index`;

/**
 * 管理员列表
 */
export const MANAGER_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/manager/index`;

/**
 * 管理员详情
 */
export const MANAGER_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/manager/view`;


/**
 * 保存管理员信息
 */
export const MANAGER_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/manager/save`;

/**
 * 删除管理员
 */
export const MANAGER_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/manager/delete`;

/**
 * 导航列表
 */
export const NAVIGATION_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/navigation/index`;

/**
 * 保存导航
 */
export const NAVIGATION_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/navigation/save`;

/**
 * 删除导航
 */
export const NAVIGATION_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/navigation/delete`;

/**
 * 导航排序
 */
export const NAVIGATION_SORT = `${HOST}/api/${API_VERSION}/${API_MODULE}/navigation/sort-change`;

/**
 * 所有导航
 */
export const NAVIGATION_ALL_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/navigation/all`;

/**
 * 角色列表
 */
export const ROLE_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/index`;

/**
 * 保存角色
 */
export const ROLE_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/save`;

/**
 * 角色详情
 */
export const ROLE_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/view`;

/**
 * 删除角色
 */
export const ROLE_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/delete`;

/**
 * 搜索角色
 */
export const ROLE_SEARCH = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/search`;

/**
 * 配置菜单
 */
export const ROLE_CONFIG_MENU = `${HOST}/api/${API_VERSION}/${API_MODULE}/role/config-menu`;

/**
 * 协议列表
 */
export const AGREEMENT_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/agreement/index`;

/**
 * 保存协议
 */
export const AGREEMENT_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/agreement/save`;

/**
 * 协议详情
 */
export const AGREEMENT_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/agreement/view`;

/**
 * 删除协议
 */
export const AGREEMENT_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/agreement/delete`;

/**
 * 投诉列表
 */
export const COMPLAINT_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/complaint/index`;

/**
 * 保存投诉
 */
export const COMPLAINT_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/complaint/save`;

/**
 * 投诉详情
 */
export const COMPLAINT_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/complaint/view`;

/**
 * 删除投诉
 */
export const COMPLAINT_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/complaint/delete`;

/**
 * 配置列表
 */
export const CONFIG_ITEMS = `${HOST}/api/${API_VERSION}/${API_MODULE}/config/index`;

/**
 * 保存配置
 */
export const CONFIG_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/config/save`;

/**
 * 删除配置
 */
export const CONFIG_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/config/delete`;


/**
 * 图片列表
 */
export const IMAGE_LISTS = `${HOST}/api/${API_VERSION}/${API_MODULE}/image/index`;

/**
 * 保存图片
 */
export const IMAGE_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/image/save`;

/**
 * 删除图片
 */
export const IMAGE_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/image/delete`;

/**
 * banner列表
 */
export const BANNER_LISTS = `${HOST}/api/${API_VERSION}/${API_MODULE}/banner/index`;

/**
 * 保存banner
 */
export const BANNER_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/banner/save`;

/**
 * 删除banner
 */
export const BANNER_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/banner/delete`;

/**
 * 标签列表
 */
export const TARGET_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/target/index`;

/**
 * 保存标签
 */
export const TARGET_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/target/save`;

/**
 * 标签详情
 */
export const TARGET_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/target/view`;

/**
 * 删除标签
 */
export const TARGET_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/target/delete`;

/**
 * 单位列表
 */
export const UNIT_LIST = `${HOST}/api/${API_VERSION}/${API_MODULE}/unit/index`;

/**
 * 保存单位
 */
export const UNIT_SAVE = `${HOST}/api/${API_VERSION}/${API_MODULE}/unit/save`;

/**
 * 单位详情
 */
export const UNIT_VIEW = `${HOST}/api/${API_VERSION}/${API_MODULE}/unit/view`;

/**
 * 删除单位
 */
export const UNIT_DELETE = `${HOST}/api/${API_VERSION}/${API_MODULE}/unit/delete`;

