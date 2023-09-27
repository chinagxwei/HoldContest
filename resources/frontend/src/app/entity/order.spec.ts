import {Order, OrderCart, OrderIncome, OrderIncomeConfig} from './order';

describe('Order', () => {
  it('should create an instance', () => {
    expect(new Order()).toBeTruthy();
  });
});

describe('OrderIncome', () => {
  it('should create an instance', () => {
    expect(new OrderIncome()).toBeTruthy();
  });
});

describe('OrderIncomeConfig', () => {
  it('should create an instance', () => {
    expect(new OrderIncomeConfig()).toBeTruthy();
  });
});

describe('OrderCart', () => {
  it('should create an instance', () => {
    expect(new OrderCart()).toBeTruthy();
  });
});
