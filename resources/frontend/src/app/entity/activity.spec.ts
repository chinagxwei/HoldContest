import {LuckyDrawsConfig, LuckyDrawsItem, Quest} from './activity';

describe('Activity', () => {
  it('should create an instance', () => {
    expect(new Quest()).toBeTruthy();
  });
});

describe('LuckyDrawsItem', () => {
  it('should create an instance', () => {
    expect(new LuckyDrawsItem()).toBeTruthy();
  });
});

describe('LuckyDrawsConfig', () => {
  it('should create an instance', () => {
    expect(new LuckyDrawsConfig()).toBeTruthy();
  });
});
