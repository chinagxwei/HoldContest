import {
  ActionLog,
  AuthenticationRequest,
  ManagerUserinfo,
  ResetPasswordRequest, ServerManager,
  UpdateUserInfoRequest,
  User,
  Userinfo
} from './user';

describe('User', () => {
  it('should create an instance', () => {
    expect(new User()).toBeTruthy();
  });
});

describe('Userinfo', () => {
  it('should create an instance', () => {
    expect(new Userinfo()).toBeTruthy();
  });
});

describe('ManagerUserinfo', () => {
  it('should create an instance', () => {
    expect(new ManagerUserinfo()).toBeTruthy();
  });
});

describe('AuthenticationRequest', () => {
  it('should create an instance', () => {
    expect(new AuthenticationRequest()).toBeTruthy();
  });
});

describe('ActionLog', () => {
  it('should create an instance', () => {
    expect(new ActionLog()).toBeTruthy();
  });
});

describe('ResetPasswordRequest', () => {
  it('should create an instance', () => {
    expect(new ResetPasswordRequest()).toBeTruthy();
  });
});

describe('UpdateUserInfoRequest', () => {
  it('should create an instance', () => {
    expect(new UpdateUserInfoRequest()).toBeTruthy();
  });
});

describe('ServerManager', () => {
  it('should create an instance', () => {
    expect(new ServerManager()).toBeTruthy();
  });
});
