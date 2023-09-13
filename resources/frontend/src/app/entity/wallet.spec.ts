import {Wallet, WalletConsume, WalletLog, WalletRecharge, WalletWithdrawAccount, WalletWithdrawal} from './wallet';

describe('Wallet', () => {
  it('should create an instance', () => {
    expect(new Wallet()).toBeTruthy();
  });
});

describe('WalletConsume', () => {
  it('should create an instance', () => {
    expect(new WalletConsume()).toBeTruthy();
  });
});

describe('WalletLog', () => {
  it('should create an instance', () => {
    expect(new WalletLog()).toBeTruthy();
  });
});

describe('WalletRecharge', () => {
  it('should create an instance', () => {
    expect(new WalletRecharge()).toBeTruthy();
  });
});

describe('WalletWithdrawAccount', () => {
  it('should create an instance', () => {
    expect(new WalletWithdrawAccount()).toBeTruthy();
  });
});

describe('WalletWithdrawal', () => {
  it('should create an instance', () => {
    expect(new WalletWithdrawal()).toBeTruthy();
  });
});
